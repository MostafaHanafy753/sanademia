<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Enroll;
use App\Models\RequestHardCopy;
use App\Models\CourseProgress;
use App\Models\CompletedExam;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends BaseController
{

    public function save_course_progress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'course_content_id' => 'required|exists:course_contents,id',
            'lecture_id' => 'required|exists:lectures,id',
            'completed_minute' => 'required',
            'remaining_minute' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $CourseProgress = CourseProgress::updateOrCreate([
            "user_id" => auth()->user()->id,
            "course_id" => $request->course_id,
            "course_content_id" => $request->course_content_id,
            "lecture_id" => $request->lecture_id,
        ], [
            "user_id" => auth()->user()->id,
            "course_id" => $request->course_id,
            "course_content_id" => $request->course_content_id,
            "lecture_id" => $request->lecture_id,
            "completed_minute" => $request->completed_minute,
            "remaining_minute" => $request->remaining_minute,
        ]);

        return $this->sendResponse($CourseProgress, 'Course progress saved successfully.');
    }

    public function get_course_progress(Request $request)
    {
        // $CourseProgress = CourseProgress::with("course")->where("user_id", auth()->user()->id)->groupBy("course_id")->get();
        $CourseProgress = CourseProgress::with("course")->groupBy("course_id")
            ->selectRaw('course_id, SUM(completed_minute) as completed_minutes, SUM(remaining_minute) as remaining_minutes')
            ->where("user_id", auth()->user()->id)->get();

        return $this->sendResponse($CourseProgress, 'Course progress get successfully.');
    }

    public function get_course_by_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $Courses = Course::with('teacher:id,name,image')
            ->where("category_id", $request->category_id)
            ->select("id", "title", "description", "intro_video_thumbnail",
                "price", "after_discount_price", "discount", "teacher_id")
            ->get();

        return $this->sendResponse($Courses, 'Course get by category successfully.');
    }

    public function course_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }


        if (auth('api')->user()) {

            $Enroll = Enroll::where("course_id", $request->course_id)->where("user_id", auth('api')->user()->id)->first();
            if (!empty($Enroll)) {
                $course = Course::withCount("enrolls")->with('teacher', 'category', 'contents.lectures')
                    ->where("id", $request->course_id)
                    ->first();
            } else {
                $course = Course::withCount("enrolls")
                    ->with([
                        'teacher',
                        'category',
                        'contents' => function ($query) {
                            $query->select('id', 'title', 'description', 'course_id');
                        },
                        'contents.lectures' => function ($query) {
                            $query->select('id', 'title', 'description', 'course_content_id', 'minutes', 'is_free', 'file');
                        }
                    ])
                    ->where("id", $request->course_id)
                    ->first();
            }
        } else {
            $course = Course::withCount("enrolls")
                ->with([
                    'teacher',
                    'category',
                    'contents' => function ($query) {
                        $query->select('id', 'title', 'description', 'course_id');
                    },
                    'contents.lectures' => function ($query) {
                        $query->select('id', 'title', 'description', 'course_content_id', 'minutes', 'is_free', 'file');
                    }
                ])
                ->where("id", $request->course_id)
                ->first();
        }


        $duration = $course->contents->flatMap(function ($content) {
            return $content->lectures;
        })->sum('minutes');

        $downloadable_resources = $course->contents->flatMap(function ($content) {
            return $content->lectures;
        })->filter(function ($lecture) {
            return !is_null($lecture->file);
        })->count();



        $course->duration = round($duration, 2);
        $course->downloadable_resources = $downloadable_resources;


        return $this->sendResponse($course, 'Course detail get successfully.');
    }

    public function request_hard_copy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $RequestHardCopy = RequestHardCopy::where("user_id", auth()->user()->id)->where("course_id", $request->course_id)->first();

        if (empty($RequestHardCopy)) {
            $RequestHardCopy = RequestHardCopy::create([
                "user_id" => auth()->user()->id,
                "course_id" => $request->course_id
            ]);
        }
        return $this->sendResponse($RequestHardCopy, 'Request hard copy sent successfully.');
    }

    public function course_enroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'payment_id' => 'required',
            'payment_status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $Enroll = Enroll::where("user_id", auth()->user()->id)->where("course_id", $request->course_id)->first();

        if (empty($Enroll)) {
            $Enroll = Enroll::create([
                "user_id" => auth()->user()->id,
                "course_id" => $request->course_id,
                "payment_id" => $request->payment_id,
                "payment_status" => $request->payment_status
            ]);
        } else {
            $Enroll = $Enroll->update([
                "course_id" => $request->course_id,
                "payment_id" => $request->payment_id,
                "payment_status" => $request->payment_status
            ]);
        }
        return $this->sendResponse($Enroll, 'Course enroll save successfully.');
    }

    public function get_certificates(Request $request)
    {

        $exam_ids = CompletedExam::where("user_id", auth()->user()->id)->pluck("exam_id")->toArray();
        $course_ids = Exam::whereIn("id", $exam_ids)->distinct("course_id")->pluck("course_id")->toArray();
        $Courses = Course::whereIn("id", $course_ids)
            ->where('registration_form', 0)
            ->get();
        foreach ($Courses as $Course) {
            $Course->certificate = asset("certificates/sample.pdf");
        }

        return $this->sendResponse($Courses, 'Certificates get successfully.');
    }

}
