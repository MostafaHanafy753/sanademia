<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;

class CourseController extends Controller
{
    use ImagesOperations;

    public function showCoursesPage(Request $request)
    {
        $categories=Category::all();
        $teachers=Teacher::all();
        return view('admin.courses.index', compact('categories','teachers'));
    }

    public function index(Request $request)
    {
        $Courses = Course::orderBy("id", "desc")
            ->with('category', 'teacher')
            ->paginate(15);
        return response()->json($Courses);
    }


    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:teachers,id',
            'title' => 'required|string|max:100',
            'intro_video' => 'required|file|mimes:mp4,webm,ogg',
            'intro_video_thumbnail' => 'required|image|mimes:jpeg,png,jpg,svg,webp',
            'description' => 'required',
            'requirements' => 'required',
            'what_will_you_learn' => 'required',
            'who_this_course_is_for' => 'required',
            'language' => 'required',
            'price' => 'required',
            'after_discount_price' => 'nullable',
            'discount' => 'nullable',
            'task_included' => 'required',
            'certificate' => 'required',
        ]);
        try {
            $imageName = $this->storeFile($request->file('intro_video_thumbnail'), 'images/courses');

            $videoName = $this->storeFile($request->file('intro_video'), 'videos/courses');

            $course = Course::create([
                'category_id' => $request->category_id,
                'teacher_id' => $request->teacher_id,
                'title' => $request->title,
                'intro_video_thumbnail' => $imageName,
                'intro_video' => $videoName,
                'language' => $request->language,
                'price' => $request->price,
                'after_discount_price' => $request->after_discount_price,
                'discount' => $request->discount,
                'task_included' => $request->task_included,
                'certificate' => $request->certificate,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'what_will_you_learn' => $request->what_will_you_learn,
                'who_this_course_is_for' => $request->who_this_course_is_for,
            ]);
            return response()->json(['data'=>$course,'message'=>'Course has been added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:teachers,id',
            'title' => 'required|string|max:100',
            'intro_video' => 'nullable|file|mimes:mp4,webm,ogg',
            'intro_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'description' => 'required',
            'requirements' => 'required',
            'what_will_you_learn' => 'required',
            'who_this_course_is_for' => 'required',
            'language' => 'required',
            'price' => 'required',
            'after_discount_price' => 'nullable',
            'discount' => 'nullable',
            'task_included' => 'required',
            'certificate' => 'required',
        ]);

        $CourseArr = [
            'category_id' => $request->category_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'language' => $request->language,
            'price' => $request->price,
            'after_discount_price' => $request->after_discount_price,
            'discount' => $request->discount,
            'task_included' => $request->task_included,
            'certificate' => $request->certificate,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'what_will_you_learn' => $request->what_will_you_learn,
            'who_this_course_is_for' => $request->who_this_course_is_for,
        ];

        if ($request->hasFile('banner')) {
            $CourseArr['intro_video_thumbnail'] = $this->storeFile($request->file('banner'), 'images/courses');
        }

        if ($request->hasFile('video')) {
            $CourseArr['intro_video'] = $this->storeFile($request->file('video'), 'videos/courses');
        }

        $course->update($CourseArr);

        return response()->json(['data'=>$course,'message'=>'Course has been updated successfully'], 201);
    }

    public function destroy(Course $Course)
    {
        $Course->delete();

        return response()->json(['message' => 'Course has been deleted successfully']);
    }

}
