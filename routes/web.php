<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/bookings', [BookingController::class, 'getBookingsByDate']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// untuk user
Route::middleware('auth')->group(function () {
    //profile akun
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //lapangan futsal
    Route::resource('fields', FieldController::class);

    //booking
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])
        ->name('booking.my');
    Route::get('/booking/create', [BookingController::class, 'create'])
        ->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])
        ->name('booking.store');
    Route::get('/payment', [BookingController::class, 'payment'])
        ->name('booking.payment');
    Route::get('/booking/availability', [BookingController::class, 'availability'])
    ->middleware('auth')
    ->name('booking.availability');


});

// untuk admin
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('fields', FieldController::class)
        ->except(['show', 'destroy']);
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/bookings/admin', [BookingController::class, 'adminIndex'])->name('bookings.admin');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
        Route::delete('/bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/booking', [BookingController::class, 'index'])
        ->name('bookings.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
});

require __DIR__.'/auth.php';
