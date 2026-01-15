<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\AvailableRoomsRequest;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Services\ApiReservationService;
use Illuminate\Http\Request;

/**
 * Class ReservationController
 * Added and deleted and updated and show and listing of reservations in API for clients
 * Summary of ReservationController
 * @package App\Http\Controllers\Api
 */
class ReservationController extends Controller
{
    protected $reservationService;

    /**
     * Constructor to initialize the reservation service.
     * Summary of __construct
     * @param ApiReservationService $reservationService
     */
    public function __construct(ApiReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the reservations.
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $reservations = $this->reservationService->getallReservations();
        return $this->success('Reservations fetched successfully', $reservations,200);
    }

    /**
     * Store a newly created reservation in storage.
     * Summary of store
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->reservationService->createReservation($request->validated());
        return $this->success('Reservation created successfully', $reservation , 201);
    }

    /**
     * Display the specified reservation.
     * Summary of show
     * @param Reservation $api_reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reservation $api_reservation)
    {
        $reservation = $this->reservationService->getReservationById($api_reservation);
        return $this->success('Reservation fetched successfully', $reservation,200);
    }

    /**
     * Update the specified reservation in storage.
     * Summary of update
     * @param UpdateReservationRequest $request
     * @param Reservation $api_reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReservationRequest $request, Reservation $api_reservation)
    {
        $reservation = $this->reservationService->updateReservation($request->validated(), $api_reservation);
        return $this->success('Reservation updated successfully', $reservation,200);
    }

    /**
     * Remove the specified reservation from storage.
     * Summary of destroy
     * @param string $id
     * @return void
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get available rooms based on criteria.
     * Summary of getAvailableRooms
     * @param AvailableRoomsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableRooms(AvailableRoomsRequest $request)
    {
        $rooms = $this->reservationService->availableRooms($request->validated());
        return $this->success('Available rooms fetched successfully', ['rooms' => $rooms, 'date' => $request->validated()],200);
    }

    /**
     * Cancel a reservation.
     * Summary of cancelReservation
     * @param Reservation $reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelReservation(Reservation $reservation)
    {
        $reservation = $this->reservationService->cancelReservation($reservation);
        return $this->success('Reservation cancelled successfully', $reservation,200);
    }
}
