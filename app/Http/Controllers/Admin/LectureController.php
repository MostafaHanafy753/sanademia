<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{

    public function index($contentId)
    {
        $content = CourseContent::findOrFail($contentId);
        return response()->json($content->lectures);
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request, $contentId)
    {
        $content = CourseContent::findOrFail($contentId);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'required',
            'file' => 'nullable|file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx,txt,zip,rar,7z,mp4,webm,ogg,mp3,wav,flac,avi,mkv,mov,wmv,flv,swf,html,css,js,php,java,py,rb,c,go,swift',
        ]);

        try {
            $videoPath = $this->storeFile($request->video, 'videos/lectures');
            if ($request->hasFile('file')) {
                $filePath = $this->storeFile($request->file, 'files/lectures');
            }
            $minutes = $this->getVideoDuration(public_path($videoPath));

            $lecture = $content->lectures()->create([
                'title' => $request->title,
                'description' => $request->description,
                'minutes' => $minutes,
                'video_url' => $videoPath,
                'file' => $filePath ?? null
            ]);


            return response()->json($lecture, 201);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function show($id)
    {
        $lecture = Lecture::findOrFail($id);
        return response()->json($lecture);
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'nullable',
            'file' => 'nullable|file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx,txt,zip,rar,7z,mp4,webm,ogg,mp3,wav,flac,avi,mkv,mov,wmv,flv,swf,html,css,js,php,java,py,rb,c,go,swift',
        ]);

        $lecture = Lecture::where("id", $id)->first();

        $LectureArr = [
            'title' => $request->title,
            'description' => $request->description,

        ];
        if ($request->hasFile('video')) {
            $LectureArr['video_url'] = $this->storeFile($request->video, 'videos/lectures');
            $LectureArr['minutes'] = $this->getVideoDuration(public_path($LectureArr['video_url']));
        }

        if ($request->hasFile('file')) {
            $LectureArr['file'] = $this->storeFile($request->file, 'files/lectures');
        }


        $lecture->update($LectureArr);

        return response()->json($lecture);
    }

    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();

        return response()->json(['message' => 'Lecture deleted']);
    }
}
