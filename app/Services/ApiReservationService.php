<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiReservationService
{
    /*
     * get all reservations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getallReservations()
    {
        $reservations = Reservation::with([
            'room' => function ($query) {
                $query->with(['images', 'roomType.services']);
            },
            'invoice'
        ])->where('user_id', auth('sanctum')->id())->get();
        return $reservations;
    }



    /*
     * get available rooms
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
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
                )->get();


            return $rooms->load(['roomType.services', 'images']);
        } catch (\Exception $e) {
            Log::error('Error fetching available rooms: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /*
     * create reservation
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createReservation(array $data)
    {
        try {

            $totalAmount = $this->totalPrice($data['room_id'], $data['start_date'], $data['end_date']);

            DB::beginTransaction();

            $reservation = Reservation::create([
                'user_id' => auth('sanctum')->id(),
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

            return $reservation->load([
                'room' => function ($query) {
                    $query->with(['images', 'roomType.services']);
                },
                'invoice'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            log::error('Error creating reservation: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /*
     * cancel reservation
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cancelReservation(Reservation $reservation)
    {
        try {
            if ($reservation->user_id !== auth('sanctum')->id()) {
                return 'unauthorized';
            }
            $reservation->status = 'cancelled';
            $reservation->save();
            return $reservation->load([
                'room' => function ($query) {
                    $query->with(['images', 'roomType.services']);
                },
                'invoice'
            ]);
        } catch (\Exception $e) {
            Log::error('Error cancelling reservation: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /*
     * get reservation by id
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReservationById(Reservation $api_reservation)
    {
        try {

            if ($api_reservation->user_id !== auth('sanctum')->id()) {
                return 'unauthorized';
            }

            return $api_reservation->load([
                'room' => function ($query) {
                    $query->with(['images', 'roomType.services']);
                },
                'invoice'
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching reservation: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /*
     * update reservation
     * @param array $data
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function updateReservation(array $data, Reservation $api_reservation)
    {
        try {
            if ($api_reservation->user_id !== auth('sanctum')->id()) {
                return 'unauthorized';
            }

            DB::beginTransaction();

            $api_reservation->update([
                'room_id' => $data['room_id'] ?? $api_reservation->room_id,
                'start_date' => $data['start_date'] ?? $api_reservation->start_date,
                'end_date' => $data['end_date'] ?? $api_reservation->end_date,
            ]);

            $api_reservation->invoice->update([
                'total_amount' => $this->totalPrice(
                    $data['room_id'] ?? $api_reservation->room_id,
                    $data['start_date'] ?? $api_reservation->start_date,
                    $data['end_date'] ?? $api_reservation->end_date
                ),
            ]);

            DB::commit();

            return $api_reservation->load([
                'room' => function ($query) {
                    $query->with(['images', 'roomType.services']);
                },
                'invoice'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating reservation: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
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
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }
}
