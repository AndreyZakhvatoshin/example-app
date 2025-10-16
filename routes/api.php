<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/service/{serviceId}/slots/{date}', [BookingController::class, 'slots'])->name('slots');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');

