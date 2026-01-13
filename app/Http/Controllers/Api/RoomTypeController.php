<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeFilterRequest;
use App\Services\ApiRoomTypeService;

class RoomTypeController extends Controller
{
    protected  $roomTypeService;

    public function __construct(ApiRoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    /**
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