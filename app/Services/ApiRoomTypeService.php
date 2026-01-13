<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;

class ApiRoomTypeService
{
    /**
     * Summary of getAll
     * @param array $filters
     * @return Collection<int, RoomType>
     */
    public function getAll(array $filters = []): Collection
    {
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
    }

    /**
     * Summary of findById
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $roomType = RoomType::with(['services', 'images'])->find($id);
        
        if (!$roomType) {
            return null;
        }

        return $this->formatRoomType($roomType);
    }

    /**
     * Summary of formatRoomType
     * @param RoomType $roomType
     * @return array{base_price: mixed, description: mixed, id: mixed, images: mixed, services: mixed, type: mixed}
     */
    private function formatRoomType(RoomType $roomType): array
    {
        return [
            'id' => $roomType->id,
            'type' => $roomType->type,
            'description' => $roomType->description,
            'base_price' => $roomType->base_price,
            'services' => $roomType->services->map(function($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name
                ];
            }),
            'images' => $roomType->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'path' => $image->path
                ];
            })
        ];
    }

    /**
     * Summary of getRoomTypesForApi
     * @param array $filters
     * @return array
     */
    public function getRoomTypesForApi(array $filters = []): array
    {
        try {
            $roomTypes = $this->getAll($filters);

            if ($roomTypes->isEmpty()) {
                return [];
            }

            return $roomTypes->map(function ($roomType) {
                return $this->formatRoomType($roomType);
            })->toArray();

        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Summary of getRoomTypeForApi
     * @param int $id
     * @return array|array{base_price: mixed, description: mixed, id: mixed, images: mixed, services: mixed, type: mixed}
     */
    public function getRoomTypeForApi(int $id): array
    {
        try {
            $roomType = RoomType::with(['services', 'images'])->find($id);

            if (!$roomType) {
                return [];
            }

            return $this->formatRoomType($roomType);

        } catch (\Exception $e) {
            return [];
        }
    }
}