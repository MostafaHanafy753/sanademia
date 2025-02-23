<?php

use App\Http\Controllers\Admin\CourseRegistrationController;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\PaymentConfirmation;
use App\Http\Controllers\Admin\RegistrationFormCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseContentController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PaymentTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RequestHardCopyController;


Route::middleware(['auth'])->group(function () {
    Route::resource('payment-confirmations/pending', \App\Http\Controllers\Admin\PaymentConfirmationPendingController::class, ['names' => 'dashboard.payment_confirmations.pending']);
    Route::resource('payment-confirmations/confirmed', \App\Http\Controllers\Admin\PaymentConfirmationConfirmedController::class, ['names' => 'dashboard.payment_confirmations.confirmed']);
    Route::resource('payment-confirmations/rejected', \App\Http\Controllers\Admin\PaymentConfirmationRejectedController::class, ['names' => 'dashboard.payment_confirmations.rejected']);

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::controller(GeneralController::class)->group(function () {
            Route::get('dashboard', 'dashboard');
            Route::get('about-us', 'about_us');
            Route::post('about-us/store', 'about_us_store');
            Route::get('get-in-touch', 'get_in_touch');
            Route::post('get-in-touch/store', 'get_in_touch_store');
        });



        Route::apiResource('api/courses', CourseController::class);

// Nested endpoints for course contents
        Route::get('api/courses/{course}/contents', [CourseContentController::class, 'index']);
        Route::post('api/courses/{course}/contents', [CourseContentController::class, 'store']);

// Endpoints for individual content items
        Route::apiResource('contents', CourseContentController::class)->except(['index', 'store']);

// Nested endpoints for lectures (by content)
        Route::get('contents/{content}/lectures', [LectureController::class, 'index']);
        Route::post('api/contents/{content}/lectures', [LectureController::class, 'store']);

// Endpoints for individual lectures
        Route::apiResource('api/lectures', LectureController::class)->except(['index', 'store']);


        Route::get('courses', [CourseController::class, 'showCoursesPage'])->name('courses.index');

        Route::resource('contact', ContactController::class);
        Route::get('course_registrations/load_courses', [CourseRegistrationController::class, 'loadCourses'])->name('load-courses');
        Route::resource('course_registrations', CourseRegistrationController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('teacher', TeacherController::class);
        Route::resource('notification', NotificationController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('registration-form/courses', RegistrationFormCourseController::class, ['names' => 'registration-form.courses']);
        Route::resource('user', UserController::class);
        Route::resource('request_hard_copy', RequestHardCopyController::class);

        Route::post('payment-types', [PaymentTypeController::class, "store"])->name("payment-types.store");
        Route::get('payment-types', [PaymentTypeController::class, "index"])->name("payment-types.index");
        Route::post('payment-types/update/{paymentType_id}', [PaymentTypeController::class, "update"])->name("payment-types.update");
// routes/web.php
Route::get('/payment-types/{paymentType}/edit', [PaymentTypeController::class, 'edit'])->name('admin.payment-types.edit');
Route::delete('/payment-types/{id}/delete', [PaymentTypeController::class, 'destroy'])->name('admin.payment-types.destroy');

        Route::resource('exam', ExamController::class);
        Route::get('question_create/{id}', [ExamController::class, "question_create"])->name("question.create");
        Route::post('question_store', [ExamController::class, "question_store"])->name("question.store");
        Route::get('question_edit/{id}', [ExamController::class, "question_edit"])->name("question.edit");
        Route::post('question_update', [ExamController::class, "question_update"])->name("question.update");
        Route::delete('question_delete/{id}', [ExamController::class, "question_delete"])->name("question.destroy");
    });
});
