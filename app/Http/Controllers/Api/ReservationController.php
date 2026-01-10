<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\AvailableRoomsRequest;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Services\ApiReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    /**
     * Constructor to initialize the reservation service.
     */
    public function __construct(ApiReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = $this->reservationService->getallReservations();
        return $this->success('Reservations fetched successfully', $reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->reservationService->createReservation($request->validated());
        return $this->success('Reservation created successfully', $reservation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $api_reservation)
    {
        $reservation = $this->reservationService->getReservationById($api_reservation);
        return $this->success('Reservation fetched successfully', $reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $api_reservation)
    {
        $reservation = $this->reservationService->updateReservation($request->validated(), $api_reservation);
        return $this->success('Reservation updated successfully', $reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get available rooms based on criteria.
     */
    public function getAvailableRooms(AvailableRoomsRequest $request)
    {
        $rooms = $this->reservationService->availableRooms($request->validated());
        return $this->success('Available rooms fetched successfully', ['rooms' => $rooms, 'date' => $request->validated()]);
    }

    /**
     * Cancel a reservation.
     */

    public function cancelReservation(Reservation $reservation)
    {
        $reservation = $this->reservationService->cancelReservation($reservation);
        return $this->success('Reservation cancelled successfully', $reservation);
    }
}
