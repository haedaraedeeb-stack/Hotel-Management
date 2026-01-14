<?php

namespace App\Services;

use App\Models\Room;

/**
 * This service handles operations related to rooms.
 * Summary of RoomService
 * @package App\Services
 */
class RoomService
{
    /**
     * Retrieve all rooms with their associated room types
     * Summary of showAllRooms
     * @return \Illuminate\Database\Eloquent\Collection<int, Room>
     */
    public function showAllRooms()
    {
        return Room::with('roomType')->get();
    }
    /**
     * Retrieve detailed information about a specific room
     * Summary of roomDetails
     * @param Room $room
     * @return Room
     */
    public function roomDetails(Room $room)
    {
        return $room->load(['roomType', 'images']);
    }
}
