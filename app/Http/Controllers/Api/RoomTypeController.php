<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Http\Requests\RoomTypeFilterRequest;

class RoomTypeController extends Controller
{
    /**
     */
    public function index(RoomTypeFilterRequest $request)
    {
        try {
            $query = RoomType::with(['services', 'images']);

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('type', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            $order_by = in_array($request->order_by, ['type', 'base_price']) ? $request->order_by : 'id';
            $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'asc';
            $query->orderBy($order_by, $direction);

            $roomTypes = $query->get();

            if ($roomTypes->isEmpty()) {
                return response()->json([]);
            }

            $data = $roomTypes->map(function ($roomType) {
                return [
                    'id' => $roomType->id,
                    'type' => $roomType->type,
                    'description' => $roomType->description,
                    'base_price' => $roomType->base_price,
                    'services' => $roomType->services->map(function($s) {
                        return ['id' => $s->id, 'name' => $s->name];
                    }),
                    'images' => $roomType->images->map(function($i) {
                        return ['id' => $i->id, 'path' => $i->path];
                    }),
                ];
            });

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     */
    public function show($id)
    {
        try {
            $roomType = RoomType::with(['services', 'images'])->find($id);

            if (!$roomType) {
                return response()->json([]);
            }

            $data = [
                'id' => $roomType->id,
                'type' => $roomType->type,
                'description' => $roomType->description,
                'base_price' => $roomType->base_price,
                'services' => $roomType->services->map(function($s) {
                    return ['id' => $s->id, 'name' => $s->name];
                }),
                'images' => $roomType->images->map(function($i) {
                    return ['id' => $i->id, 'path' => $i->path];
                }),
            ];

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([]);
        }
    }
}
