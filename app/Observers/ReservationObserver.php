<?php

namespace App\Observers;

use App\Mail\ReservationConfirme;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationObserver
{
    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void 
    {
        if ($reservation->isDirty('status') && $reservation->status === "confirmed" && $reservation->getOriginal('status') != 'confirmed') {
            if ($reservation->user && $reservation->user->email) {
                Mail::to($reservation->user->email)->send(new ReservationConfirme($reservation));
            }
        }

        if ($reservation->isDirty('check_in') && !is_null($reservation->check_in)) {
            $reservation->room->update(['status' => 'occupied']);
        }
        
        if ($reservation->isDirty('status') && $reservation->status === 'completed') {
            $reservation->room->update(['status' => 'available']);
        }
        
        if ($reservation->isDirty('status') && in_array($reservation->status, ['cancelled', 'rejected'])) {
            $reservation->room->update(['status' => 'available']);
        }
    }
}