<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
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
        $services = Service::select('id','name','description')->get();
        return response()->json([
            'success' => true,
            'data' => $services
        ],200);
    } catch (\Exception $e) {
        Log::error('Error fetching services: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error fetching services',
        ], 500);
    }
}

    /**
     * Retrieve a single service by ID
     * Summary of showSingleService
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showSingleService($id)
    {
        try {
            return Service::findOrFail($id); // Returns model
        } catch (ModelNotFoundException $e) {
            Log::error('Service not found: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404));
        } catch (\Exception $e) {
            Log::error('Error fetching service: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error fetching service',
            ], 500));
        }
    }
}
