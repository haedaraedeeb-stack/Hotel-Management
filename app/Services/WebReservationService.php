<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebReservationService
{
    /*
     * get all reservations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllReservations()
    {
        return Reservation::with('room', 'user')->latest()->get();
    }

    /*
     * store a new reservation
     * @param array $data
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function storeReservation(array $data)
    {
        try {
            $totalAmount = $this->totalPrice($data['room_id'], $data['start_date'], $data['end_date']);

            DB::beginTransaction();

            $reservation = Reservation::create([
                'user_id' => $data['user_id'],
                'room_id' => $data['room_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]);

            Invoice::create([
                'reservation_id' => $reservation->id,
                'total_amount' => $totalAmount,
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
            ]);

            DB::commit();
            return $totalAmount;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating reservation: ' . $e->getMessage());
            abort(500);
        }
    }

    /*
     * update a reservation
     * @param Reservation $reservation
     * @param array $data
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function updateReservation(Reservation $reservation, array $data)
    {
        try {
            DB::beginTransaction();
            $reservation->update([
                'user_id' => $data['user_id'] ?? $reservation->user_id,
                'room_id' => $data['room_id'] ?? $reservation->room_id,
                'start_date' => $data['start_date'] ?? $reservation->start_date,
                'end_date' => $data['end_date'] ?? $reservation->end_date,
                'status' => $data['status'] ?? $reservation->status,
                'check_in' => $data['check_in'] ?? $reservation->check_in,
                'check_out' => $data['check_out'] ?? $reservation->check_out,
            ]);

            $reservation->invoice->update([
                'total_amount' => $this->totalPrice(
                    $data['room_id'] ?? $reservation->room_id,
                    $data['start_date'] ?? $reservation->start_date,
                    $data['end_date'] ?? $reservation->end_date
                ),
            ]);
            DB::commit();
            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating reservation: ' . $e->getMessage());
            abort(500);
        }
    }

    /*
     * check in a reservation
     * @param Reservation $reservation
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function checkIn(Reservation $reservation)
    {
        try {
            DB::beginTransaction();
            $reservation->update([
                'check_in' => now(),
                'status' => 'confirmed'
            ]);
            $reservation->room->update(['status' => 'occupied']);
            if ($reservation->invoice && $reservation->invoice->payment_status == 'unpaid') {
                $reservation->invoice->update([
                    'payment_status' => 'paid',
                ]);
            }
            DB::commit();
            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error checking in reservation: ' . $e->getMessage());
            abort(500);
        }
    }

    /*
     * check out a reservation
     * @param Reservation $reservation
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function checkOut(Reservation $reservation)
    {
        try {
            DB::beginTransaction();
            $reservation->update([
                'check_out' => now(),
                'status' => 'completed'
            ]);
            $reservation->room->update(['status' => 'available']);
            DB::commit();
            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error checking out reservation: ' . $e->getMessage());
            abort(500);
        }
    }


    /*
     * get available rooms
     * @param array $criteria
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function availableRooms(array $criteria)
    {
        try {
            $rooms = Room::with('images', 'roomType.services')
                ->whereDoesntHave(
                    'reservations',
                    function ($query) use ($criteria) {
                        $query->where('status', '!=', 'cancelled')->where(
                            function ($q) use ($criteria) {
                                $q->whereBetween('start_date', [$criteria['start_date'], $criteria['end_date']])
                                    ->orWhereBetween('end_date', [$criteria['start_date'], $criteria['end_date']])
                                    ->orWhere(
                                        function ($subQ) use ($criteria) {
                                            $subQ->where('start_date', '<=', $criteria['start_date'])
                                                ->where('end_date', '>=', $criteria['end_date']);
                                        }
                                    );
                            }
                        );
                    }
                );

                if(isset($criteria['reservation_id'])) {
                    $rooms->whereDoesntHave('reservations', function ($query) use ($criteria) {
                        $query->where('id', $criteria['reservation_id']);
                    });
                }


            return $rooms->get();
        } catch (\Exception $e) {
            Log::error('Error fetching available rooms: ' . $e->getMessage());
            abort(500);
        }
    }

    /*
     * get total price
     */
    public function totalPrice($roomId, $startDate, $endDate)
    {
        try {
            $room = Room::findOrFail($roomId);
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nights = $start->diffInDays($end) ?: 1;
            return $room->current_price * $nights;
        } catch (\Exception $e) {
            Log::error('Error fetching total price: ' . $e->getMessage());
            abort(500);
        }
    }
}
