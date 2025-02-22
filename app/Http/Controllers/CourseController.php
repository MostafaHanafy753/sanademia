<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET /api/courses
    public function index()
    {
        return response()->json(Course::all());
    }

    // GET /api/courses/{id}
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    // POST /api/courses
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'teacher_id'  => 'required|string',
            'price'    => 'required|numeric',
        ]);

        $course = Course::create($data);

        return response()->json($course, 201);
    }

    // PUT/PATCH /api/courses/{id}
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'title'    => 'sometimes|required|string',
            'category' => 'sometimes|required|string',
            'teacher'  => 'sometimes|required|string',
            'price'    => 'sometimes|required|numeric',
        ]);

        $course->update($data);

        return response()->json($course);
    }

    // DELETE /api/courses/{id}
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
