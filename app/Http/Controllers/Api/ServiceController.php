<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::withTrashed()->get(); // عرض الكل بما فيه المحذوف SoftDelete
            return response()->json($services, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch services'], 500);
        }
    }

    public function store(ServiceRequest $request)
    {
        try {
            $service = Service::create($request->validated());
            return response()->json($service, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create service'], 500);
        }
    }

    public function show($id)
    {
        try {
            $service = Service::withTrashed()->findOrFail($id);
            return response()->json($service, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->update($request->validated());
            return response()->json($service, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update service'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete(); // SoftDelete
            return response()->json(['message' => 'Service deleted'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete service'], 500);
        }
    }

    public function restore($id)
    {
        try {
            $service = Service::withTrashed()->findOrFail($id);
            if ($service->trashed()) {
                $service->restore();
                return response()->json(['message' => 'Service restored'], 200);
            }
            return response()->json(['message' => 'Service is not deleted'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }
}
