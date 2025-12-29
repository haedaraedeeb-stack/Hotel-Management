<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = $this->roomService->getAllRooms();
       
        return view('room.index', compact('rooms'));
    }

    public function create()
    {
        $roomtypes = RoomType::select('id', 'type', 'description', 'base_price')->get();
        return view('room.create', compact('roomtypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        // return $request;
        $result = $this->roomService->storeRoom($request->validated());

        if ($result['success']) {
            return redirect()->route('rooms.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return $id;
        $room = $this->roomService->getRoomById($id);

        if (!$room) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found');
        }

        return view('room.show', compact('room'));
    }

    public function edit($id)
    {
        $room = $this->roomService->getRoomById($id);
        $roomtypes = RoomType::select('id', 'type', 'description', 'base_price')->get();

        if (!$room) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found');
        }

        return view('room.edit', compact('room', 'roomtypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $result = $this->roomService->updateRoom($request->validated(), $room->id);
        // return $result;

        if ($result['success']) {
            return redirect()->route('rooms.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->roomService->deleteRoom($id);

        if ($result['success']) {
            return redirect()->route('rooms.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }
}
