<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enroll;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function my_enrollments()
    {
        $user = Auth::user();
        $myCourses = Enroll::with(['course','payment_type'])->where('user_id',$user->id)->get();


        $myCourses=$myCourses->map(function($item){
            $item->course->image = static_asset('uploads/'.$item->course->image);
            $item->course->course_contents = $item->course->course_contents->map(function($content){
                $content->progress = CourseProgress::where('user_id',Auth::user()->id)->where('course_id',$content->course_id)->where('course_content_id',$content->id)->first();
                return $content;
            });
//            $totalMinutes = $item->course->course_contents->sum('minutes');
//            $completedMinutes = CourseProgress::where('user_id',Auth::user()->id)->where('course_id',$item->course_id)->sum('minutes');
//            $item->progress=($completedMinutes/$totalMinutes)*100;
            return $item;
        });
       return $this->sendResponse($myCourses, 'My Courses retrieved successfully.');
    }
}
