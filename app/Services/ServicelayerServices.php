<?php

namespace App\Services;

use App\Models\Service;

class ServicelayerServices
{
    public function getAll()
    {
        return Service::with('roomTypes')->latest()->get();
    }

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

    public function delete(Service $service)
    {
        return $service->delete(); // soft delete
    }

    public function getTrashed()
    {
        return Service::onlyTrashed()->get();
    }

    public function restore($id)
    {
        return Service::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Service::onlyTrashed()->findOrFail($id)->forceDelete();
    }
}