<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['room', 'user'])->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $users = User::all();

        return view('reservations.create', compact('rooms', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $isBooked = Reservation::where('room_id', $request->room_id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                    ->where('end_date', '>', $request->start_date);
            })->exists();

        if ($isBooked) {
            return back()->withErrors(['room_id' => 'Sorry, This room is occupied in this date!'])
                ->withInput();
        }

        $room = Room::with('roomType')->findOrFail($request->room_id);
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $nights = $start->diffInDays($end) ?: 1;

        $totalAmount = $room->current_price * $nights;

        DB::transaction(function () use ($request, $totalAmount) {
            $reservation = Reservation::create([
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
            ]);

            Invoice::create([
                'reservation_id' => $reservation->id,
                'total_amount' => $totalAmount,
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
            ]);
        });

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation Done And The Invoice Created With Value: '.$totalAmount.'$');
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
        $rooms = Room::all();
        $users = User::all();

        return view('reservations.edit', compact('reservation', 'rooms', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $isBooked = Reservation::where('room_id', $request->room_id)
            ->where('status', 'confirmed')
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                    ->where('end_date', '>', $request->start_date);
            })
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['room_id' => 'Sorry this new dates is unavailable!'])
                ->withInput();
        }

        $dateChanged = $request->start_date != $reservation->start_date || $request->end_date != $reservation->end_date;
        $roomChanged = $request->room_id != $reservation->room_id;

        DB::transaction(function () use ($request, $reservation, $dateChanged, $roomChanged) {
            $reservation->update([
                'room_id' => $request->room_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            if (($dateChanged || $roomChanged) && $reservation->invoice) {
                $room = Room::with('roomType')->find($request->room_id);
                $start = Carbon::parse($request->start_date);
                $end = Carbon::parse($request->end_date);
                $nights = $start->diffInDays($end) ?: 1;

                $newTotal = $room->current_price * $nights;

                $reservation->invoice()->update([
                    'total_amount' => $newTotal,
                ]);
            }
        });

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

        DB::transaction(function () use ($reservation) {

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

        });

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

        DB::transaction(function () use ($reservation) {

            $reservation->update([
                'check_out' => now(),
            ]);
            $reservation->room->update(['status' => 'available']);
        });

        return back()->with('success', ' the checkout is done , and the invoice done , room is avaiable!');
    }
}
