<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\AvailableRoomsRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Services\WebReservationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReservationController
 * @package App\Http\Controllers\Web
 * Controller for managing reservations
 * @author Haedara Deeb
 * @edit by Mohammad Shaheen
 *Permissions:
 * - view reservations
 * - create reservations
 * - edit reservations
 * - delete reservations
 * - checkin reservations
 * - checkout reservations
 * - CRUD operations for reservations
 * - Check-in and Check-out handling
 */
class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(WebReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
        $this->middleware('permission:reservation-list', ['only' => ['index']]);
        $this->middleware('permission:reservation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:reservation-show', ['only' => ['show', 'availableRooms']]);
        $this->middleware('permission:reservation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:reservation-delete', ['only' => ['destroy']]);
        $this->middleware('permission:reservation-checkin-checkout', ['only' => ['checkIn', 'checkOut']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = $this->reservationService->getallReservations();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $rooms = Room::where('status', 'available')->get();
        $users = User::all();

        return view('reservations.create', compact( 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $totalAmount = $this->reservationService->storeReservation($request->validated());
        return redirect()->route('reservations.index')
            ->with('success', 'Reservation Done And The Invoice Created With Value: ' . $totalAmount . '$');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['room.roomType', 'user', 'invoice']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        // $rooms = Room::all();
        $users = User::all();

        return view('reservations.edit', compact('reservation', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $updateReservation = $this->reservationService->updateReservation($reservation, $request->validated());
        return redirect()->route('reservations.index')->with('success', 'Updated Done...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Deleted..');
    }

    public function checkIn(Reservation $reservation)
    {
        if (!in_array($reservation->status, ['confirmed', 'pending'])) {
            return back()->with('error', 'Reservation is cancelled or rejected!');
        }

        if ($reservation->check_in) {
            return back()->with('error', 'checkin already');
        }

        if ($reservation->room->status === 'occupied') {
            return back()->with('error', 'sorry room still occuiped , the user must exit from room now!');
        }

        $CheckIn = $this->reservationService->checkIn($reservation);

        return back()->with('success', 'checkin done successufly!');
    }

    public function checkOut(Reservation $reservation)
    {
        if (! $reservation->check_in) {
            return back()->with('error', 'can not checkout because there is no checkin yet!');
        }

        if ($reservation->check_out) {
            return back()->with('error', 'already cheackout done');
        }

        $checkOut = $this->reservationService->checkOut($reservation);
        return back()->with('success', ' the checkout is done , and the invoice done , room is avaiable!');
    }

    public function getAvailableRooms(AvailableRoomsRequest $request)
    {
        $availableRooms = $this->reservationService->availableRooms($request->validated());
        return response()->json([
            'rooms' => $availableRooms,
            'count' => $availableRooms->count(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }
}
