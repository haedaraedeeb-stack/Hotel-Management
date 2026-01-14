<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use App\Models\Service;
use App\Services\WebRoomTypeService;

class RoomTypeController extends Controller
{
    protected WebRoomTypeService $roomTypeService;

    public const PERMISSIONS = [
        'view'   => 'view room_types',
        'create' => 'create room_types',
        'edit'   => 'edit room_types',
        'delete' => 'delete room_types',
    ];

    public function __construct(WebRoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;

        $this->middleware('permission:' . self::PERMISSIONS['view'])->only(['index', 'show']);
        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
    }

    public function index()
    {
        $roomTypes = $this->roomTypeService->getAll();
        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        $services = Service::all();
        return view('room_types.create', compact('services'));
    }

    public function store(RoomTypeRequest $request)
    {
        $this->roomTypeService->store(
            $request->validated(),
            $request->file('images')
        );

        return redirect()->route('room_types.index')
            ->with('success', 'Room type created successfully');
    }

    public function show(RoomType $roomType)
    {
        return view('room_types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        $services = Service::all();
        $roomType->load('services', 'images');

        return view('room_types.edit', compact('roomType', 'services'));
    }

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

    public function destroy(RoomType $roomType)
    {
        $this->roomTypeService->destroy($roomType);

        return redirect()->route('room_types.index')
            ->with('success', 'Room type deleted successfully');
    }
}
