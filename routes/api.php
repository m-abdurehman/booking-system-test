<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('bookings', BookingController::class);
    Route::get('services/search', [ServiceController::class, 'search']);
    Route::post('bookings/{id}/confirm', [BookingController::class, 'confirm']);
});
