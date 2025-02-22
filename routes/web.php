<?php

use App\Http\Controllers\Admin\CourseRegistrationController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Middleware\TrackGuestMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', TrackGuestMiddleware::class, \App\Http\Middleware\CalculateVisits::class]
], function () {
    Route::get('', function (){
        return redirect()->route('registration');
    })->name('home');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('registration', [AuthController::class, 'courseRegistration'])->name('registration');
    Route::post('registration', [AuthController::class, 'postCourseRegistration']);
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('register-to-course/{slug}', [CourseRegistrationController::class, 'register_to_course'])->name('register_to_course');
});


