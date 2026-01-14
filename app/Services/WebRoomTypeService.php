<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebRoomTypeService
{
    public function getAll()
    {
        return RoomType::with(['images', 'services'])->get();
    }

    public function store(array $data, ?array $images = null): RoomType
    {
        return DB::transaction(function () use ($data, $images) {

            $roomType = RoomType::create($data);

            if (!empty($data['services'])) {
                $roomType->services()->sync($data['services']);
            }

            if ($images) {
                foreach ($images as $image) {
                    $path = $image->store('room_types', 'public');
                    $roomType->images()->create(['path' => $path]);
                }
            }

            return $roomType;
        });
    }

    public function update(RoomType $roomType, array $data, ?array $images = null): RoomType
    {
        return DB::transaction(function () use ($roomType, $data, $images) {

            $roomType->update($data);

            if (isset($data['services'])) {
                $roomType->services()->sync($data['services']);
            }

            if ($images) {
                foreach ($roomType->images as $image) {
                    Storage::disk('public')->delete($image->path);
                }
                $roomType->images()->delete();

                foreach ($images as $image) {
                    $path = $image->store('room_types', 'public');
                    $roomType->images()->create(['path' => $path]);
                }
            }

            return $roomType;
        });
    }

    public function destroy(RoomType $roomType): void
    {
        DB::transaction(function () use ($roomType) {

            foreach ($roomType->images as $image) {
                Storage::disk('public')->delete($image->path);
            }

            $roomType->images()->delete();
            $roomType->services()->detach();
            $roomType->delete();
        });
    }
}
