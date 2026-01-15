<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

/**
 * This service handles API operations related to room types, including retrieval and formatting for API responses.
 * Summary of ApiRoomTypeService
 * @package App\Services
 */
class ApiRoomTypeService
{
    /**
     * Summary of getAll
     * @param array $filters
     * @throws HttpResponseException
     * @return Collection<int, RoomType>
     */
    public function getAll(array $filters = [])
    {
        try {
            $query = RoomType::with(['services', 'images']);

            if (!empty($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('type', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                });
            }

            $orderBy = $filters['order_by'] ?? 'id';
            $direction = $filters['direction'] ?? 'asc';

            if (in_array($orderBy, ['type', 'base_price', 'id'])) {
                $query->orderBy($orderBy, $direction);
            }

            return $query->get();
        } catch (\Exception $e) {
            Log::error('Error fetching room types: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /**
     * Summary of getRoomTypeForApi
     * @param RoomType $roomType
     * @throws HttpResponseException
     * @return array
     */
    public function getRoomTypeForApi(RoomType $roomType): array
    {
        try {
            return $roomType->load(['services', 'images'])->toArray();
        } catch (\Exception $e) {
            Log::error('Error fetching room type: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }
}
