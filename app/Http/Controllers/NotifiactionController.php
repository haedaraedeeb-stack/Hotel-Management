<?php

namespace App\Http\Controllers;

use App\Notifications\ReservationStore;
use App\Notifications\RoomNotifiation;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class NotifiactionController extends Controller
{
    public function readNotification( $notification)
    {
        $user = Auth::user();
        $n = $user->unreadNotifications()->where('id', $notification)->first();
        $n->markAsRead();
        if($n->type == ReservationStore::class){
            return redirect()->route('reservations.index');
        }
        if($n->type == RoomNotifiation::class){
            return redirect()->route('rooms.show', $n->data['room_id']);
        }
        return redirect()->back();
    }

    public function readAllNotification()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
