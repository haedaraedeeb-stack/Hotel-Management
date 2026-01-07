<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\CustomerInvoiceController;

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

// 5. Reservation api
Route ::middleware('auth:sanctum')->group(function () {
    Route::apiResource('api_reservations', ReservationController::class);
    Route::post('api_reservations/available-rooms', [ReservationController::class, 'getAvailableRooms']);
    Route::patch('api_reservations/cancel/{reservation}', [ReservationController::class, 'cancelReservation']);
});
// 6. Ratings:
Route::prefix('ratings')->group(function () {

    Route::get('/', [RatingController::class, 'index']);
    Route::get('/reservation/{reservationId}', [RatingController::class, 'getByReservation']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('my-ratings',[RatingController::class, 'myRatings']);
        Route::post('/', [RatingController::class, 'store']);
        Route::put('/{id}', [RatingController::class, 'update']);
        Route::delete('/{id}', [RatingController::class, 'destroy']);
    });
    
    Route::get('/{id}', [RatingController::class, 'show']);
    
    Route::middleware(['auth:sanctum', 'role:admin,manager'])->group(function () {
        Route::get('/stats', [RatingController::class, 'stats']);
    });
});
// 7. invoices

Route::get('customer/invoices/{id?}', [CustomerInvoiceController::class, 'getInvoices']);
