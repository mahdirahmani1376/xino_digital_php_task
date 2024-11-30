<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'controller' => PaymentController::class,
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/payment/success','success')->name('payment.success');
    Route::get('/payment/cancel','cancel')->name('payment.cancel');
    Route::post('/payment/webhook','webhook')->name('payment.webhook');
    Route::post('/payment/create-plan','createPlan')->name('payment.create-plan');
});

Route::group([
    'controller' => CourseController::class,
    'middleware' => ['auth:sanctum']
], function() {
    Route::get('see-course','seeCourse')
        ->middleware('section:view_course')
        ->name('course.view_course');
    Route::get('download-course','donwloadCourse')
        ->middleware('section:download_course')
        ->name('course.download_course');
    Route::get('send-message','sendDirectMessageToMentor')
        ->middleware('section:send_direct_messages_to_mentor')
        ->name('course.send_direct_messages_to_mentor');
});

Route::group([
    'controller' => InvoiceController::class,
    'prefix' => 'invoices'
], function() {
    Route::get('/{invoice}','show')
        ->name('invoices.show');
    Route::post('/','store')->name('invoices.store');
    Route::post('/pay/{invoice}','pay')->name('invoices.pay');
});

Route::group([
    'controller' => InvoiceController::class,
    'prefix' => 'subscriptions',
    'middleware' => ['auth:sanctum']
], function() {
    Route::post('/store','store')->name('subscriptions.store');
});