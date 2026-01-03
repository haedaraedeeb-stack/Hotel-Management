<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\RoomTypeController;
use App\Http\Controllers\Web\ReservationController;

use App\Http\Controllers\Web\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('rooms', RoomController::class);
    Route::resource('room_types', RoomTypeController::class);

    // Reservations
    Route::resource('reservations', ReservationController::class);
    // Custom Actions (Check In/Out)
    Route::post('/reservations/{reservation}/check-in', [ReservationController::class, 'checkIn'])->name('reservations.checkIn');
    Route::post('/reservations/{reservation}/check-out', [ReservationController::class, 'checkOut'])->name('reservations.checkOut');
});

Route::middleware('auth')->group(function () {
    Route::get(
        'invoices/trashed',[InvoiceController::class, 'trashed']
    )->name('invoices.trashed');
    Route::get(
        'reservations/{reservationId}/invoices/create',[InvoiceController::class, 'create']
    )->name('invoices.create');
    Route::post(
        'reservations/{reservationId}/invoices',[InvoiceController::class, 'store']
    )->name('invoices.store');
    Route::patch(
        'invoices/{id}/restore',[InvoiceController::class, 'restore']
    )->name('invoices.restore');
    Route::delete(
        'invoices/{id}/force',[InvoiceController::class, 'forceDelete']
    )->name('invoices.forceDelete');

    Route::resource('invoices', InvoiceController::class)
        ->except(['store', 'create']);

});



require __DIR__ . '/auth.php';


    Route::resource('users', UserController::class);
    Route::get('users-trash', [UserController::class,'trash'])->name('users.trash');
    Route::post('users/{id}/restore', [UserController::class,'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class,'forceDelete'])->name('users.forceDelete');


require __DIR__.'/auth.php';
