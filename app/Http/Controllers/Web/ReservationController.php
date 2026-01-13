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
 */
class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(WebReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
        $this->middleware('permission:reservation-list', ['only' => ['index']]);
        $this->middleware('permission:reservation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:reservation-show', ['only' => ['show']]);
        $this->middleware('permission:reservation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:reservation-delete', ['only' => ['destroy']]);
        $this->middleware('permission:reservation-checkin-checkout', ['only' => ['checkIn', 'checkOut']]);
        $this->middleware('permission:reservation-confirm-reject', ['only' => ['confirmeReservation', 'rejectedReservation']]);
    }
    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
// <<<<<<< HEAD
//         $reservations = $this->reservationService->getAllReservations($request);
//         return view('reservations.index', compact('reservations'));
// =======
        // return $request;
        $reservations = $this->reservationService->getallReservations($request);
        return view('reservations.index', compact('reservations', 'request'));
// >>>>>>> af6562d6cd0fd2f7c954af9e3a7de69d323c2cbe
    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // $rooms = Room::where('status', 'available')->get();
        $users = User::all();
        return view('reservations.create', compact('users'));
    }

    /**
     * Summary of store
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $totalAmount = $this->reservationService->storeReservation($request->validated());
        return redirect()->route('reservations.index')
            ->with('success', 'Reservation Done And The Invoice Created With Value: ' . $totalAmount . '$');
    }

    /**
     * Summary of show
     * @param Reservation $reservation
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['room.roomType', 'user', 'invoice']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Summary of edit
     * @param Reservation $reservation
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Reservation $reservation)
    {
        // $rooms = Room::all();
        $users = User::all();

        return view('reservations.edit', compact('reservation', 'users'));
    }

    /**
     * Summary of update
     * @param UpdateReservationRequest $request
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $updateReservation = $this->reservationService->updateReservation($reservation, $request->validated());
        return redirect()->route('reservations.index')->with('success', 'Updated Done...✔✔');
    }

    /**
     * Summary of destroy
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->back()->with('success', 'Deleted..');
    }
   
    /**
     * Summary of checkIn
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkIn(Reservation $reservation)
    {
        // return "dsdsadd";
        if (in_array($reservation->status, ['cancelled', 'rejected'])) {
            return back()->with('error', 'Reservation is cancelled or rejected!');
        }

        if ($reservation->status != 'confirmed') {
            return back()->with('error', 'Reservation is not confirmed yet!');
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

    /**
     * Summary of checkOut
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Summary of getAvailableRooms
     * @param AvailableRoomsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableRooms(AvailableRoomsRequest $request)
    {
        // return $request;
        $availableRooms = $this->reservationService->availableRooms($request->validated());
        return response()->json([
            'rooms' => $availableRooms,
            'count' => $availableRooms->count(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }

    /**
     * Summary of confirmeReservation
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmeReservation(Reservation $reservation)
    {
        $data = [
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
            'reservation_id' => $reservation->id,
            'room_id' => $reservation->room_id,
        ];
        $rooms = $this->reservationService->availableRooms($data)->pluck('id')->toArray();

        // if (!in_array($data['room_id'], $rooms)) {
        //     return back()->with('error', 'Room is already booked');
        // }

        $confirmedReservations = $this->reservationService->confirme($reservation);
        return redirect()->back()->with('success', 'Confirmed Reservations Fetched successufly!');
    }

    /**
     * Summary of rejectedReservation
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectedReservation(Reservation $reservation)
    {
        $rejectedReservation = $this->reservationService->rejected($reservation);
        return redirect()->back()->with('success', 'rejected Reservations Fetched successufly!');
    }
}
