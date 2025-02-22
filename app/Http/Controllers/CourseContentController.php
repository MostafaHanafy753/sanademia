<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;

class CourseContentController extends Controller
{
    // GET /api/courses/{course}/contents
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        return response()->json($course->contents);
    }

    // POST /api/courses/{course}/contents
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
        ]);

        $content = $course->contents()->create($data);

        return response()->json($content, 201);
    }

    // GET /api/contents/{id}
    public function show($id)
    {
        $content = CourseContent::findOrFail($id);
        return response()->json($content);
    }

    // PUT/PATCH /api/contents/{id}
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

    // DELETE /api/contents/{id}
    public function destroy($id)
    {
        $content = CourseContent::findOrFail($id);
        $content->delete();

        return response()->json(['message' => 'Content deleted']);
    }
}
