<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\RoomService;

/**
 * This controller manages API requests related to rooms, including
 * listing all rooms and viewing specific room details.
 * Summary of RoomController
 * @package App\Http\Controllers\Api
 */
class RoomController extends Controller
{
    protected RoomService $roomService;

    /**
     * Constructor to initialize the room service.
     * Summary of __construct
     * @param RoomService $roomService
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of all available rooms.
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success'=> true,
            'data'=> $this->roomService->showAllRooms(),
        ]);
    }

    /**
     * Display the specified room details.
     * Summary of show
     * @param Room $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Room $room)
    {
        return response()->json([

        'success'=>true,
        'data'=>$this->roomService->roomDetails($room),
        ]);
    }}

