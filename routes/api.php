<?php

<<<<<<< HEAD
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
=======
>>>>>>> 829179bc042ee4d882c7f76fcd53e4d221a8f3e0
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\RoomController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
<<<<<<< HEAD
Route::get('services', [ServiceController::class, 'index']); 
Route::get('services/{id}', [ServiceController::class, 'show']);
=======
Route::apiResource('services', \App\Http\Controllers\Api\ServiceController::class);
Route::post('services/{id}/restore', [\App\Http\Controllers\Api\ServiceController::class, 'restore']);
Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
    Route::get('/{id}', [RoomTypeController::class, 'show']);
});
>>>>>>> 829179bc042ee4d882c7f76fcd53e4d221a8f3e0


// guest and user (customer) have the same routes:
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);
