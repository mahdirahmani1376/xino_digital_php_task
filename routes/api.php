<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/payment/{transaction}/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/{transaction}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

