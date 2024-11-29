<?php

use App\Http\Controllers\CourseController;
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
    Route::post('/payment/create-plan','createPlan')->name('payment.create-plan');
});

Route::group([
    'controller' => CourseController::class,
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