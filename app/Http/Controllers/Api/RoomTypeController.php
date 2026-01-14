<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeFilterRequest;
use App\Services\ApiRoomTypeService;

/**
 * This controller manages API requests related to room types, including
 * listing all room types and viewing specific room type details.
 * Summary of RoomTypeController
 * @package App\Http\Controllers\Api
 */
class RoomTypeController extends Controller
{
    protected  $roomTypeService;

    public function __construct(ApiRoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    /**
     * Display a listing of the room types for API with optional filters.
     * Summary of index
     * @param RoomTypeFilterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoomTypeFilterRequest $request)
    {
        $roomTypes = $this->roomTypeService->getRoomTypesForApi($request->validated());
        
        return response()->json($roomTypes);
    }

    /**
     * Display the specified room type.
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $roomType = $this->roomTypeService->getRoomTypeForApi($id);
        
        return response()->json($roomType);
    }
}