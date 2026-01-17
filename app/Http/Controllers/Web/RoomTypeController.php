<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use App\Models\Service;
use App\Services\WebRoomTypeService;

/**
 * This controller manages room type-related web requests,
 * including listing, creating, updating, showing, and deleting room types.
 * Class RoomTypeController
 * @package App\Http\Controllers\Web
 */
class RoomTypeController extends Controller
{
    protected WebRoomTypeService $roomTypeService;

    public const PERMISSIONS = [
        'view'   => 'view room_types',
        'create' => 'create room_types',
        'edit'   => 'edit room_types',
        'delete' => 'delete room_types',
    ];

    /**
     * RoomTypeController constructor.
     * Summary of __construct
     * @param WebRoomTypeService $roomTypeService
     */
    public function __construct(WebRoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;

        $this->middleware('permission:' . self::PERMISSIONS['view'])->only(['index', 'show']);
        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
    }

    /**
     * Display a listing of room types.
     * Summary of index
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roomTypes = $this->roomTypeService->getAll();
        return view('room_types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new room type.
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $services = Service::all();
        return view('room_types.create', compact('services'));
    }

    /**
     * Store a newly created room type in storage.
     * Summary of store
     * @param RoomTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoomTypeRequest $request)
    {
        $this->roomTypeService->store(
            $request->validated(),
            $request->file('images')
        );

        return redirect()->route('room_types.index')
            ->with('success', 'Room type created successfully');
    }

    /**
     * Display the specified room type.
     * Summary of show
     * @param RoomType $roomType
     * @return \Illuminate\View\View
     */
    public function show(RoomType $roomType)
    {
        return view('room_types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified room type.
     * Summary of edit
     * @param RoomType $roomType
     * @return \Illuminate\View\View
     */
    public function edit(RoomType $roomType)
    {
        $services = Service::all();
        $roomType->load('services', 'images');

        return view('room_types.edit', compact('roomType', 'services'));
    }

    /**
     * Update the specified room type in storage.
     * Summary of update
     * @param UpdateRoomTypeRequest $request
     * @param RoomType $roomType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $this->roomTypeService->update(
            $roomType,
            $request->validated(),
            $request->file('images')
        );

        return redirect()->route('room_types.index')
            ->with('success', 'Room type updated successfully');
    }

    /**
     * Remove the specified room type from storage.
     * Summary of destroy
     * @param RoomType $roomType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RoomType $roomType)
    {
        $this->roomTypeService->destroy($roomType);

        return redirect()->route('room_types.index')
            ->with('success', 'Room type deleted successfully');
    }
}
