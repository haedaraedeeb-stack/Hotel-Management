<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RoomTypeController;

// 1. Authenticated User (Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// --- Public Routes (Customer/Guest - Read Only) ---

Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);

// 3. Room Types
Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
    Route::get('/{id}', [RoomTypeController::class, 'show']);
});

// 4. Rooms
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);


// --- Customer/Guest Auth Routes ---
Route::post('/register', [AuthController::class, 'register']); // يُرجع توكن
Route::post('/login', [AuthController::class, 'login']);       // يُرجع توكن
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route ::middleware('auth:sanctum')->group(function () {
    Route::apiResource('api_reservations', ReservationController::class);
    Route::post('api_reservations/available-rooms', [ReservationController::class, 'getAvailableRooms']);
    Route::patch('api_reservations/cancel/{reservation}', [ReservationController::class, 'cancelReservation']);
});

