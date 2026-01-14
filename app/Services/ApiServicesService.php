<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * This service handles API operations related to services.
 * Summary of ApiServicesService
 * @package App\Services
 */
class ApiServicesService
{
    /**
     * Retrieve all services
     * Summary of showAllServices
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllServices()
    {
        try {
            $services = Service::all();
            return response()->json($services, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch services'], 500);
        }
    }

    /**
     * Retrieve a single service by ID
     * Summary of showSingleService
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showSingleService($id)
    {
        try {
            $service = Service::findOrFail($id);
            return response()->json($service, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }
}
