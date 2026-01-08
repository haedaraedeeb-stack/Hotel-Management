<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

/**
 * Class RoomTypeController
 * @package App\Http\Controllers\Web
 * Controller for managing room types
 * @author Haedara Deeb
 *Permissions:
 * - view room_types
 * - create room_types
 * - edit room_types
 * - delete room_types
 * - CRUD operations for room types
 * - Image handling for room types
 */

class RoomTypeController extends Controller
{
    public const PERMISSIONS = [
        'view'  => 'view room_types',
        'create' => 'create room_types',
        'edit' => 'edit room_types',
        'delete' => 'delete room_types',
    ];
    public function __construct()
    {
        $this->middleware('permission:' . self::PERMISSIONS['view'])->only(['index', 'show']);
        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
    }

    public function index()
    {
        $roomTypes = RoomType::with(['images', 'services'])->get();

        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        $services = Service::all();

        return view('room_types.create', compact('services'));
    }

    public function store(RoomTypeRequest $request)
    {
        $data = $request->validated();

        $roomType = RoomType::create($data);

        if ($request->has('services')) {
            $roomType->services()->attach($request->services);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('room_types', 'public');
                $roomType->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('room_types.index');
    }

    public function show(RoomType $roomType)
    {
        return view('room_types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        $services = Service::all();
        $roomType->load('services');

        return view('room_types.edit', compact('roomType', 'services'));
    }

    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $data = $request->validated();
        $roomType->update($data);
        if ($request->hasFile('images')) {
            foreach ($roomType->images as $image) {
                Storage::disk('public')->delete($image->path);
            }
            $roomType->images()->delete();
            foreach ($request->file('images') as $file) {
                $path = $file->store('room_types', 'public');
                $roomType->images()->create(['path' => $path]);
            }
        }
        if ($request->has('services')) {
            $roomType->services()->sync($request->services);
        } else {
            $roomType->services()->detach();
        }

        return redirect()->route('room_types.index')->with('success', 'Room type updated successfully');
    }

    public function destroy(RoomType $roomType)
    {
        foreach ($roomType->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);

            }
            $image->delete();
        }
        $roomType->delete();

        return redirect()->route('room_types.index')->with('success', 'Room type deleted successfully');
    }
}
