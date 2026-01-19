<?php

namespace App\Services;

use App\Models\Service;

/**
 * This service handles operations related to services,
 * including CRUD operations and management of soft-deleted records and their relationships with room types.
 * Summary of ServicelayerServices
 * @package App\Services
 */
class ServicelayerServices
{
    /**
     * Retrieve all services with their associated room types
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection<int, Service>
     */
    public function getAll()
    {
        return Service::with('roomTypes')->latest()->get();
    }

    /**
     * Create a new service and associate it with room types
     * Summary of create
     * @param array $data
     * @return Service
     */
    public function create(array $data)
    {
        $service = Service::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        if (!empty($data['room_types'])) {
            $service->roomTypes()->sync($data['room_types']);
        }

        return $service;
    }

    /**
     * Update an existing service and its associated room types
     * Summary of update
     * @param Service $service
     * @param array $data
     * @return Service
     */
    public function update(Service $service, array $data)
    {
        $service->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        if (array_key_exists('room_types', $data)) {
            $service->roomTypes()->sync($data['room_types'] ?? []);
        }

        return $service;
    }

    /**
     * Soft delete a service
     * Summary of delete
     * @param Service $service
     * @return bool|null
     */
    public function delete(Service $service)
    {
        return $service->delete(); // soft delete
    }

    /**
     * Retrieve all soft-deleted services
     * Summary of getTrashed
     * @return \Illuminate\Database\Eloquent\Collection<int, Service>
     */
    public function getTrashed()
    {
        return Service::onlyTrashed()->get();
    }

    /**
     * Restore a soft-deleted service
     * Summary of restore
     * @param mixed $id
     * @return bool
     */
    public function restore($id)
    {
        return Service::onlyTrashed()->findOrFail($id)->restore();
    }

    /**
     * Permanently delete a soft-deleted service by ID
     * Summary of forceDelete
     * @param mixed $id
     * @return bool|null
     */
    public function forceDelete($id)
    {
        return Service::onlyTrashed()->findOrFail($id)->forceDelete();
    }
}