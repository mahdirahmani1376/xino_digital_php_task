<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'controller' => PaymentController::class,
], function () {
    Route::get('/payment/success','success')->name('payment.success');
    Route::get('/payment/cancel','cancel')->name('payment.cancel');
    Route::post('/payment/webhook','webhook')->name('payment.webhook');
});