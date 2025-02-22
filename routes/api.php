<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ProvinceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Middleware\TrackGuestMiddleware;

Route::controller(AuthController::class)
    ->middleware(\App\Http\Middleware\LanguageMiddleware::class)
    ->group(function () {
        Route::post('register', 'register');

        Route::post('phone-exists', 'phone_exists');

        Route::post('register-first-step', 'register_first_step');
        Route::post('register-second-step', 'register_second_step');

        Route::post('login', 'login');

        Route::post('resend-code', 'resend_code');
        Route::post('verify-otp', 'verify_otp');
    });

Route::middleware([TrackGuestMiddleware::class, \App\Http\Middleware\CalculateVisits::class, \App\Http\Middleware\LanguageMiddleware::class])->group(function () {


    Route::get('cities', [CityController::class, 'index']);
    Route::get('provinces', [ProvinceController::class, 'index']);


    Route::get('get_in_touch', [GeneralController::class, 'get_in_touch']);
    Route::get('about_us', [GeneralController::class, 'about_us']);
    Route::post('contact', [GeneralController::class, 'contact']);
    Route::post('notifications', [GeneralController::class, 'notifications']);

    Route::get('categories', [GeneralController::class, 'categories']);
    Route::get('banners', [GeneralController::class, 'banners']);
    Route::get('courses', [GeneralController::class, 'courses']);

    Route::post('get_course_by_category', [CourseController::class, 'get_course_by_category']);
    Route::post('course_detail', [CourseController::class, 'course_detail']);

    Route::get('payment-types', [\App\Http\Controllers\Api\PaymentTypeController::class, 'index']);

    Route::middleware(['auth:api'])->group(function () {

        Route::get('user', [AuthController::class, 'get_profile']);
        Route::post('update_profile', [AuthController::class, 'update_profile']);
        Route::delete('delete_user', [AuthController::class, 'delete_user']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('my-enrollments', [HomeController::class, 'my_enrollments']);

        Route::post('save_course_progress', [CourseController::class, 'save_course_progress']);
        Route::post('get_course_progress', [CourseController::class, 'get_course_progress']);
        Route::post('request_hard_copy', [CourseController::class, 'request_hard_copy']);
        Route::post('course_enroll', [CourseController::class, 'course_enroll']);
        Route::get('get_certificates', [CourseController::class, 'get_certificates']);

        Route::post('get_exams', [ExamController::class, 'get_exams']);
        Route::post('get_questions', [ExamController::class, 'get_questions']);
        Route::post('save_questions_answers', [ExamController::class, 'save_questions_answers']);
        Route::post('exam_result', [ExamController::class, 'exam_result']);


        Route::post('payments', [\App\Http\Controllers\Api\PaymentController::class, 'store']);
    });
});
Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
});
