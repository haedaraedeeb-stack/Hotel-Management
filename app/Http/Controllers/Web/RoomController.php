<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * This controller manages room-related web requests,
 * including listing, creating, updating, showing, and deleting rooms.
 * Class RoomController
 * @package App\Http\Controllers\Web
 */
class RoomController extends Controller
{
    protected $roomService;

    /**
     * RoomController constructor.
     * Summary of __construct
     * @param RoomService $roomService
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
        $this->middleware('permission:room-list' , ['only' =>['index']]);
        $this->middleware('permission:room-create' , ['only' =>['create' , 'store']]);
        $this->middleware('permission:room-show' , ['only' =>['show']]);
        $this->middleware('permission:room-edit' , ['only' =>['edit' , 'update']]);
        $this->middleware('permission:room-delete' , ['only' =>['destroy']]);
    }

    /**
     * Display a listing of rooms.
     * Summary of index
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $rooms = $this->roomService->getAllRooms();

        return view('Room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roomtypes = RoomType::select('id', 'type', 'description', 'base_price')->get();
        return view('Room.create', compact('roomtypes'));
    }

    /**
     * Store a newly created room in storage.
     * Summary of store
     * @param StoreRoomRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified room.
     * Summary of show
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // return $id;
        $room = $this->roomService->getRoomById($id);

        if (!$room) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found');
        }

        return view('Room.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     * Summary of edit
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $room = $this->roomService->getRoomById($id);
        $roomtypes = RoomType::select('id', 'type', 'description', 'base_price')->get();

        if (!$room) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found');
        }

        return view('Room.edit', compact('room', 'roomtypes'));
    }

    /**
     * Update the specified room in storage.
     * Summary of update
     * @param UpdateRoomRequest $request
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
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
     * Remove the specified room from storage.
     * Summary of destroy
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
