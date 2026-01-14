<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServicesService;

class ServiceController extends Controller
{
        protected ApiServicesService $services ;
     
    public function __construct(ApiServicesService $services) {
        $this->services = $services;
        $this->middleware('role:client'); 
    }

    public function index()
    {
        return $this->services->showAllServices();
    }

    public function show($id)
    {
        return $this->services->showSingleService($id);
    }

}
