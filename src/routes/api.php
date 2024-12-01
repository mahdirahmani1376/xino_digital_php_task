<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => UserController::class,
], function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::get('/show', 'show')->name('users.register')->middleware('auth:sanctum');
});

Route::get('subscription_plans', [SubscriptionPlanController::class, 'index']);

Route::group([
    'controller' => PaymentController::class,
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/payment/success', 'success')->name('payment.success');
    Route::get('/payment/cancel', 'cancel')->name('payment.cancel');
    Route::post('/payment/webhook', 'webhook')->name('payment.webhook');
    Route::post('/payment/create-plan', 'createPlan')->name('payment.create-plan');
});

Route::group([
    'controller' => CourseController::class,
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('see-course', 'seeCourse')
        ->middleware('section:view_course')
        ->name('course.view_course');
    Route::get('download-course', 'donwloadCourse')
        ->middleware('section:download_course')
        ->name('course.download_course');
    Route::get('send-message', 'sendDirectMessageToMentor')
        ->middleware('section:send_direct_messages_to_mentor')
        ->name('course.send_direct_messages_to_mentor');
});

Route::group([
    'controller' => InvoiceController::class,
    'prefix' => 'invoices',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/{invoice}', 'show')
        ->name('invoices.show');
    Route::post('/', 'store')->name('invoices.store');
    Route::post('/pay/{invoice}', 'pay')->name('invoices.pay');
});

Route::group([
    'controller' => SubscriptionController::class,
    'prefix' => 'subscriptions',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::post('/store', 'store')->name('subscriptions.store');
});
