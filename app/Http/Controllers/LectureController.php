<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    // GET /api/contents/{content}/lectures
    public function index($contentId)
    {
        $content = CourseContent::findOrFail($contentId);
        return response()->json($content->lectures);
    }

    // POST /api/contents/{content}/lectures
    public function store(Request $request, $contentId)
    {
        $content = CourseContent::findOrFail($contentId);

        $data = $request->validate([
            'title'    => 'required|string',
            'duration' => 'required|numeric',
            // Add other lecture fields here if needed.
        ]);

        $lecture = $content->lectures()->create($data);

        return response()->json($lecture, 201);
    }

    // GET /api/lectures/{id}
    public function show($id)
    {
        $lecture = Lecture::findOrFail($id);
        return response()->json($lecture);
    }

    // PUT/PATCH /api/lectures/{id}
    public function update(Request $request, $id)
    {
        $lecture = Lecture::findOrFail($id);

        $data = $request->validate([
            'title'    => 'sometimes|required|string',
            'duration' => 'sometimes|required|numeric',
        ]);

        $lecture->update($data);

        return response()->json($lecture);
    }

    // DELETE /api/lectures/{id}
    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();

        return response()->json(['message' => 'Lecture deleted']);
    }
}
