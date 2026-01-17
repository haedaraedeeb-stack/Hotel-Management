<?php

namespace App\Services;

use App\Mail\ReservationConfirme;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * This service handles operations related to web reservations, including creating, updating, checking in/out, confirming,
 * rejecting, calculating total price, and fetching available rooms.
 * Summary of WebReservationService
 * @package App\Services
 */
class WebReservationService
{
    /**
     * Get all reservations with optional filters
     * Summary of getAllReservations
     * @param mixed $data
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllReservations($data)
    {
        $reservations = Reservation::with('room', 'user')
        ->when($data['start_date'] , function ($query, $start_date) {
            $query->where('start_date', '>=', $start_date);
        })->when($data['end_date'] , function ($query, $end_date) {
            $query->where('end_date', '<=', $end_date);
        })->when($data['status'] , function ($query, $status) {
            $query->where('status', $status);
        })
        ->paginate($data['limit'] ?? 10);

        return $reservations;
    }

    /**
     * Store a new reservation along with its invoice
     * Summary of storeReservation
     * @param array $data
     * @return float|int
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
            Log::error('Error creating reservation: '.$e->getMessage());
            abort(500);
        }
    }

    /**
     * Update an existing reservation and its invoice
     * Summary of updateReservation
     * @param Reservation $reservation
     * @param array $data
     * @return Reservation
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
            Log::error('Error updating reservation: '.$e->getMessage());
            abort(500);
        }
    }

    /**
     * Check in a reservation
     * Summary of checkIn
     * @param Reservation $reservation
     * @return Reservation
     */
    public function checkIn(Reservation $reservation)
    {
        try {
            DB::beginTransaction();
            $reservation->update([
                'check_in' => now(),
                'status' => 'confirmed',
            ]);

            if ($reservation->invoice && $reservation->invoice->payment_status == 'unpaid') {
                $reservation->invoice->update([
                    'payment_status' => 'paid',
                ]);
            }
            DB::commit();

            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error checking in reservation: '.$e->getMessage());
            abort(500);
        }
    }

    /**
     * Check out a reservation
     * Summary of checkOut
     * @param Reservation $reservation
     * @return Reservation
     */
    public function checkOut(Reservation $reservation)
    {
        try {
            DB::beginTransaction();
            $reservation->update([
                'check_out' => now(),
                'status' => 'completed',
            ]);
            DB::commit();

            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error checking out reservation: '.$e->getMessage());
            abort(500);
        }
    }

    /**
     * Get available rooms based on criteria
     * Summary of availableRooms
     * @param array $criteria
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function availableRooms(array $criteria)
    {
        try {
            $rooms = Room::with('images', 'roomType.services')->whereIn('status', ['available' , 'occupied'])
            ->whereDoesntHave(
                'reservations',
                    function ($query) use ($criteria) {
                        $query->where('status', '=', 'confirmed')
                            ->where('id', '!=', $criteria['reservation_id'] ?? null)
                                ->where(
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

            if (isset($criteria['reservation_id'])) {
                $rooms->whereDoesntHave('reservations', function ($query) use ($criteria) {
                    $query->where('id', $criteria['reservation_id']);
                });
            }


            return $rooms->get();
        } catch (\Exception $e) {
            Log::error('Error fetching available rooms: '.$e->getMessage());
            abort(500);
        }
    }

    /**
     * Confirm a reservation
     * Summary of confirme
     * @param Reservation $reservation
     * @return Reservation
     */
    public function confirme(Reservation $reservation)
    {
        try {
            $reservation->update([
                'status' => 'confirmed'
            ]);


            return $reservation;
        } catch (\Exception $e) {
            Log::error('Error confirming reservation: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     * Reject a reservation
     * Summary of rejected
     * @param Reservation $reservation
     * @return Reservation
     */
    public function rejected(Reservation $reservation)
    {
        try {
            $reservation->update([
                'status' => 'rejected'
            ]);
            return $reservation;
        } catch (\Exception $e) {
            Log::error('Error rejecting reservation: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     * Calculate total price for a reservation
     * Summary of totalPrice
     * @param mixed $roomId
     * @param mixed $startDate
     * @param mixed $endDate
     * @return float|int
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
            Log::error('Error fetching total price: '.$e->getMessage());
            abort(500);
        }
    }
}
