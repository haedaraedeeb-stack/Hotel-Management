<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\RoomController;

Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
    Route::get('/{id}', [RoomTypeController::class, 'show']);
});


// guest and user (customer) have the same routes:
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);
