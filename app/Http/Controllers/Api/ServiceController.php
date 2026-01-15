<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServicesService;
use Illuminate\Http\Exceptions\HttpResponseException;

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
    }

    /**
     * Display a listing of the services.
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $services = $this->services->showAllServices();
            return $this->success('', $services, 200);
        } catch (HttpResponseException $e) {
            throw $e; // Re-throw the HttpResponseException
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    /**
     * Display the specified service.
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $service = $this->services->showSingleService($id);
            return $this->success('', $service, 200);
        } catch (HttpResponseException $e) {
            throw $e; // Re-throw the HttpResponseException
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }
}
