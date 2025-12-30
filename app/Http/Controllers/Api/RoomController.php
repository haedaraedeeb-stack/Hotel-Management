<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\RoomService;

class RoomController extends Controller
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index()
    {
        return response()->json($this->roomService->showAllRooms());
    }

    public function show(Room $room)
    {
        return response()->json($this->roomService->roomDetails($room));
    }
}
