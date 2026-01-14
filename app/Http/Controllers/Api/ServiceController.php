<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServicesService;

/**
 * This controller handles API requests related to services, including
 * listing all services and viewing specific service details.
 * Summary of ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{
 
        protected ApiServicesService $services ;
     

    /**
     * Constructor to initialize the services service.
     * Summary of __construct
     * @param ApiServicesService $services
     */
    public function __construct(ApiServicesService $services) {
        $this->services = $services;
        $this->middleware('role:client');
    }

    /**
     * Display a listing of the services.
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->services->showAllServices();
    }

    /**
     * Display the specified service.
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->services->showSingleService($id);
    }

}
