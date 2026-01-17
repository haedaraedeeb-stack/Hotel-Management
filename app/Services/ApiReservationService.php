<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\ReservationStore;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * This service handles API operations related to reservations,including creation, retrieval, updating,
 * and cancelling reservations, checking room availability and calculating total prices.
 * Summary of ApiReservationService
 * @package App\Services
 */
class ApiReservationService
{
    /**
     * get all reservations for the authenticated API user
     * Summary of getallReservations
     * @return \Illuminate\Database\Eloquent\Collection<int, Reservation>
     */
    public function getallReservations()
    {
        $reservations = Reservation::with([
            'room' => function ($query) {
                $query->with(['images', 'roomType.services']);
            },
            'invoice'
        ])->where('user_id', auth('api')->id())->get();
        return $reservations;
    }



    /**
     * get available rooms based on criteria
     * Summary of availableRooms
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection<int, Room>
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
            return $rooms->get();
        } catch (\Exception $e) {
            Log::error('Error fetching available rooms: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /**
     * create a new reservation for the authenticated user and generate its invoice
     * Summary of createReservation
     * @param array $data
     * @throws HttpResponseException
     * @return Reservation
     */
    public function createReservation(array $data)
    {
        try {

            $totalAmount = $this->totalPrice($data['room_id'], $data['start_date'], $data['end_date']);

            DB::beginTransaction();

            $reservation = Reservation::create([
                'user_id' => Auth::id(),
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

            Notification::send(
                User::permission(['reservation-confirm-reject'])->get(),
                new ReservationStore($reservation->id,
                 auth('api')->user()->name,
                  $reservation->room->room_number)
            );

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

    /**
     * Cancel a reservation for the authenticated user
     * Summary of cancelReservation
     * @param Reservation $reservation
     * @throws HttpResponseException
     * @return Reservation
     */
    public function cancelReservation(Reservation $reservation)
    {
        if ($reservation->user_id !== auth('api')->id()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403));
        }
        try {
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

    /**
     * Get a reservation by ID for the authenticated user
     * Summary of getReservationById
     * @param Reservation $api_reservation
     * @throws HttpResponseException
     * @return Reservation
     */
    public function getReservationById(Reservation $api_reservation)
    {
        if ($api_reservation->user_id !== auth('api')->id()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403));
        }
        try {

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

    /**
     * Update an existing reservation for the authenticated user
     * Summary of updateReservation
     * @param array $data
     * @param Reservation $api_reservation
     * @throws HttpResponseException
     * @return Reservation
     */
    public function updateReservation(array $data, Reservation $api_reservation)
    {
        if ($api_reservation->user_id !== auth('api')->id()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403));
        }
        try {

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


    /**
     * Get total price for a reservation based on room and dates
     * Summary of totalPrice
     * @param mixed $roomId
     * @param mixed $startDate
     * @param mixed $endDate
     * @throws HttpResponseException
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
            Log::error('Error fetching total price: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }
}
