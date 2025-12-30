<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    public function showAllRooms()
    {
        return Room::with('roomType')->get();
    }
    public function roomDetails(Room $room)
    {
        return $room->load(['roomType', 'images']);
    }
}
