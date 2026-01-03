<?php


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RoomTypeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('services', ServiceController::class);
Route::post('services/{id}/restore', [ServiceController::class, 'restore']);


// --- Public Routes (Customer/Guest) ---

// 1. Services (Read Only)
Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);

// 2. Room Types

Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
    Route::get('/{id}', [RoomTypeController::class, 'show']);
});


// 3. Rooms
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);