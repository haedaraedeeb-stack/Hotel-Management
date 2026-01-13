<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceController extends Controller
{
    public function __construct() {
        $this->middleware('role:client'); 
    }

    public function index()
    {
        try {
            $services = Service::all();
            return response()->json($services, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch services'], 500);
        }
    }
    public function store()
    {
        
    }


    public function show($id)
    {
        try {
            $service = Service::findOrFail($id);
            return response()->json($service, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }


}
