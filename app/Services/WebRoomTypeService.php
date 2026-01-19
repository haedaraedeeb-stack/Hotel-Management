<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * This service handles operations related to web room types, including creation, updating, retrieval, and deletion.
 * Summary of WebRoomTypeService
 * @package App\Services
 */
class WebRoomTypeService
{
    /**
     * Retrieve all room types with their images and services
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection<int, RoomType>
     */
    public function getAll()
    {
        return RoomType::with(['images', 'services'])->get();
    }

    /**
     * Update a specific room type with its images and services
     * Create a new room type with associated services and images
     * Summary of store
     * @param array $data
     * @param mixed $images
     * @return RoomType
     */
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

    /**
     * Update a specific room type with its images and services
     * Summary of update
     * @param RoomType $roomType
     * @param array $data
     * @param mixed $images
     * @return RoomType
     */
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

    /**
     * Delete a specific room type along with its images and service associations
     * Summary of destroy
     * @param RoomType $roomType
     * @return void
     */
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
