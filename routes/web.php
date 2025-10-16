<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/service/{serviceId}/calendar', [BookingController::class, 'calendar'])->name('calendar');
