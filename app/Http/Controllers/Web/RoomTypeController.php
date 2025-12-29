<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('images')->get();

        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room_types.create');
    }

    public function store(RoomTypeRequest $request)
    {
        $data = $request->validated();
        $roomType = RoomType::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('room_types', 'public');
                $roomType->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('room_types.index')->with('success', 'Room type created successfully');
    }

    public function show( RoomType $roomType)
    {
        return view('room_types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $data = $request->validated();
        $roomType->update($data);
        if ($request->hasFile('images')) {
            foreach($roomType->images as $image)
            {
                Storage::disk('public')->delete($image->path);
            }
            $roomType->images()->delete();
            foreach ($request->file('images') as $file) {
                $path = $file->store('room_types', 'public');
                $roomType->images()->create(['path' => $path]);
            }
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
