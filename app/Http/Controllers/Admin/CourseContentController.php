<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Lecture;


class CourseContentController extends Controller
{
    use ImagesOperations;

    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        return response()->json($course->contents);
    }
    public function store(Request $request,$courseId)
    {
        $course = Course::findOrFail($courseId);

        $data= $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $content = $course->contents()->create($data);

        return response()->json($content, 201);
    }

    public function show($id)
    {
        $content = CourseContent::findOrFail($id);
        return response()->json($content);
    }

    public function update(Request $request, $id)
    {
        $content = CourseContent::findOrFail($id);

        $data = $request->validate([
            'title'       => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
        ]);

        $content->update($data);

        return response()->json($content);
    }

    public function destroy($id)
    {
        $content = CourseContent::findOrFail($id);
        $content->delete();

        return response()->json(['message' => 'Content deleted']);
    }



}
