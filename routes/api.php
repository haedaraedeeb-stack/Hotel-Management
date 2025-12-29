<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;

// guest and user (customer) have the same routes:
Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/{room}', [RoomController::class, 'show']);
