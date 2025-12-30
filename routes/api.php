<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\RoomController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('services', \App\Http\Controllers\Api\ServiceController::class);
Route::post('services/{id}/restore', [\App\Http\Controllers\Api\ServiceController::class, 'restore']);
Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
    Route::get('/{id}', [RoomTypeController::class, 'show']);
});


// guest and user (customer) have the same routes:
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);
