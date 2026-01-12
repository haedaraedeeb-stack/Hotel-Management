<?php

use App\Http\Controllers\NotifiactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\RatingController;
use App\Http\Controllers\Web\ReservationController;
use App\Http\Controllers\Web\RolesController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\RoomTypeController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes (Accessible by everyone)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard' , [DashboardController::class, 'index'])->name('dashboard');

    // 2. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. User Management
    Route::get('users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    Route::resource('users', UserController::class);

    // 4. Role Management
    Route::resource('roles', RolesController::class);

    // 5. Room & Room Type Management
    Route::resource('rooms', RoomController::class);
    Route::resource('room_types', RoomTypeController::class);

    // 6. Service Management
    Route::get('serv/trash', [ServiceController::class, 'trash'])->name('serv.trash');
    Route::patch('serv/{id}/restore', [ServiceController::class, 'restore'])->name('serv.restore');
    Route::delete('serv/{id}/force-delete', [ServiceController::class, 'forceDelete'])->name('serv.forceDelete');
    Route::resource('serv', ServiceController::class)
        ->parameters(['serv' => 'service'])
        ->except(['show']);

    // 7. Reservation Management
    // Custom Actions first
    Route::post('/reservations/{reservation}/check-in', [ReservationController::class, 'checkIn'])->name('reservations.checkIn');
    Route::post('/reservations/{reservation}/check-out', [ReservationController::class, 'checkOut'])->name('reservations.checkOut');
    Route::post('reservations/available_rooms', [ReservationController::class, 'getAvailableRooms'])->name('reservations.getAvailableRooms');
    Route::get('reservations/comfirme/{reservation}', [ReservationController::class, 'confirmeReservation'])->name('comfirme_Reservation');
    Route::get('reservations/rejected/{reservation}', [ReservationController::class, 'rejectedReservation'])->name('rejected_Reservation');
    Route::resource('reservations', ReservationController::class);

    // 8. Invoice Management
    Route::get('invoices/trashed', [InvoiceController::class, 'trashed'])->name('invoices.trashed');
    Route::patch('invoices/{id}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');
    Route::delete('invoices/{id}/force', [InvoiceController::class, 'forceDelete'])->name('invoices.forceDelete');
    // Invoice Creation linked to Reservation
    Route::get('reservations/{reservationId}/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('reservations/{reservationId}/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    
    Route::resource('invoices', InvoiceController::class)->except(['store', 'create']);

    // 9. Ratings (Read Only for Admin)
    Route::resource('ratings', RatingController::class)->except(['edit', 'update', 'create', 'store']);

    // 10. Notifications
    Route::get('readnotification/{notification}', [NotifiactionController::class, 'readNotification'])->name('readnotification');
    Route::get('readallnotification', [NotifiactionController::class, 'readAllNotification'])->name('readallnotification');


});


require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // CRUD الخدمات (باستثناء show)
    Route::resource('services', ServiceController::class)
        ->except(['show']);

    // صفحة المهملات
    Route::get('services-trash', [ServiceController::class, 'trash'])
        ->name('services.trash');

    // استعادة خدمة
    Route::patch('services/{id}/restore', [ServiceController::class, 'restore'])
        ->name('services.restore');

    // حذف نهائي
    Route::delete('services/{id}/force-delete', [ServiceController::class, 'forceDelete'])
        ->name('services.forceDelete');
});

require __DIR__.'/auth.php';
