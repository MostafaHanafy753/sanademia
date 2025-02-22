<?php
// Courses endpoints
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {

    Route::middleware('auth')->group(function () {

    });

});
