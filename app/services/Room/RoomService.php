<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Models\RoomType;
use App\Services\ImageService;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Get all rooms with their room types and images
     */
    public function getAllRooms()
    {
        try {
            $rooms = Room::with(['roomType', 'images'])->get();
            return $rooms;
        } catch (\Exception $e) {
            Log::error('Error fetching rooms: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Create a new room with images
     */
    public function storeRoom($data)
    {
        // return $data;
        try {
            DB::beginTransaction();

            // Create the room
            $room = Room::create([
                'room_number' => $data['room_number'],
                'room_type_id' => $data['room_type_id'],
                'status' => $data['status'],
                'price_per_night' => $data['price'],
                'floor' => $data['floor'],
                'view' => $data['view'],
            ]);

            // Upload and attach images if provided
            if (isset($data['images']) && is_array($data['images'])) {
                $this->imageService->uploadMultipleImages($data['images'], $room, 'rooms');
            }

            DB::commit();

            // Load relationships
            $room->load(['roomType', 'images']);


            return [
                'success' => true,
                'message' => 'Room created successfully.',
                'room' => $room
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create room: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to create room: ' 
            ];
        }
    }

    /**
     * Update an existing room with images
     */
    public function updateRoom($data, $roomId)
    {
        try {
            DB::beginTransaction();
            $room = Room::findOrFail($roomId);
            // return var_dump($room->room_number);

            // Update room details
            $room->update([
                'room_number' => $data['room_number'] ?? $room->room_number,
                'room_type_id' => $data['room_type_id'] ?? $room->room_type_id,
                'status' => $data['status'] ?? $room->status,
                'price_per_night' => $data['price'] ?? $room->price_per_night,
                'floor' => $data['floor'] ?? $room->floor,
                'view' => $data['view'] ?? $room->view,
            ]);

            // Delete images if specified
            if (isset($data['images_to_delete']) && is_array($data['images_to_delete'])) {
                $this->imageService->deleteMultipleImages($data['images_to_delete']);
            }

            // Add new images if provided
            if (isset($data['new_images']) && is_array($data['new_images'])) {
                $this->imageService->uploadMultipleImages($data['new_images'], $room, 'rooms');
            }

            DB::commit();

            // Load relationships
            $room->load(['roomType', 'images']);



            return [
                'success' => true,
                'message' => 'Room updated successfully.',
                'room' => $room
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update room: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to update room: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a room with its images
     */
    public function deleteRoom($roomId)
    {
        try {
            DB::beginTransaction();

            $room = Room::findOrFail($roomId);

            // Delete all images associated with the room
            $this->imageService->deleteModelImages($room);

            // Delete the room
            $room->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Room deleted successfully.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete room: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to delete room: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get room by ID with room types and images
     */
    public function getRoomById($roomId)
    {
        try {
            // return $roomId;
            $room = Room::with(['roomType', 'images'])->findOrFail($roomId);
            return $room;
        } catch (\Exception $e) {
            Log::error('Error fetching room: ' . $e->getMessage());
            return null;
        }
    }



}
