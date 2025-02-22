<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent; 
use App\Models\Lecture; 
use FFMpeg;

class CourseContentController extends Controller
{
    public function index(Request $request)
    { 
        $CourseContents = CourseContent::orderBy("id","desc")->get();
        return view('admin.course_contents.index', compact('CourseContents'));
    }
     
    public function create()
    {
        $Courses = Course::get();
        return view('admin.course_contents.create', compact("Courses"));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
            // 'number_of_lecture' => 'required',
            'description' => 'required',
        ]);

        CourseContent::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            // 'number_of_lecture' => $request->number_of_lecture,
            'description' => $request->description,
        ]);
     
        return redirect()->route('admin.course_content.index')->with('success','Lecture created successfully.');
    }
     
    public function edit(CourseContent $CourseContent)
    {
        $Courses = Course::get();
        return view('admin.course_contents.edit',compact('Courses', 'CourseContent'));
    }
    
    public function update(Request $request, CourseContent $CourseContent)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
            // 'number_of_lecture' => 'required',
            'description' => 'required',
        ]);

        $CourseContentArr = [
            'course_id' => $request->course_id,
            'title' => $request->title,
            // 'number_of_lecture' => $request->number_of_lecture,
            'description' => $request->description,
        ];

        $CourseContent->update($CourseContentArr);
    
        return redirect()->route('admin.course_content.index')->with('success','Lecture updated successfully');
    }
    
    public function destroy(CourseContent $CourseContent)
    {
        $CourseContent->delete();
    
        return redirect()->route('admin.course_content.index')->with('success','Lecture deleted successfully');
    }

    public function show($id)
    { 
        $Lectures = Lecture::where("course_content_id", $id)->orderBy("id","desc")->get();
        return view('admin.course_contents.lecture_index', compact('Lectures'));
    }
     
    public function lecture_create()
    {
        return view('admin.course_contents.lecture_create');
    }
    
    public function lecture_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'required',
            'minutes' => 'required',
        ]);

        $videoName = rand(1111,9999) . time().'.'.$request->video->extension();  
     
        // $minutes = $this->getVideoDuration($videoPath);

        $CourseContent = CourseContent::where("id", $request->course_content_id)->first();
        $CourseContent->number_of_lecture = $CourseContent->number_of_lecture + 1;
        $CourseContent->minutes = $CourseContent->minutes + $request->minutes;
        $CourseContent->save();

        $Course = Course::where("id", $CourseContent->course_id)->first();
        $Course->number_of_lecture = $Course->number_of_lecture + 1;
        $Course->minutes = $Course->minutes +  $request->minutes;
        $Course->save();

        $request->video->move(public_path('videos'), $videoName);
        Lecture::create([
            'course_content_id' => $request->course_content_id,
            'title' => $request->title,
            'description' => $request->description,
            'minutes' => $request->minutes,
            'video_url' => $videoName,
        ]);
     
        return redirect()->route('admin.course_content.show', $request->course_content_id)->with('success','Lecture created successfully.');
    }
     
    public function lecture_edit($id)
    {
        $Lecture = Lecture::where("id", $id)->first();
        return view('admin.course_contents.lecture_edit',compact('Lecture'));
    }
    
    public function lecture_update(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'minutes' => 'required',
        ]);
        
        $Lecture = Lecture::where("id", $id)->first();

        $LectureArr = [
            'title' => $request->title,
            'description' => $request->description,
            'minutes' => $request->minutes,
        ];
        if($request->hasFile('video'))
        {
            $videoName = rand(1111,9999) . time().'.'.$request->video->extension();  
            $request->video->move(public_path('videos'), $videoName);
            $LectureArr['video_url'] = $videoName;                    
        } 

        $CourseContent = CourseContent::where("id", $Lecture->course_content_id)->first();
        $CourseContent->minutes = ($CourseContent->minutes - $Lecture->minutes) +  $request->minutes;
        $CourseContent->save();

        $Course = Course::where("id", $CourseContent->course_id)->first();
       
        $Course->minutes = ($Course->minutes - $Lecture->minutes) +  $request->minutes;
        $Course->save();

        $Lecture->update($LectureArr);
    
        return redirect()->route('admin.course_content.show', $Lecture->course_content_id)->with('success','Lecture updated successfully');
    }
    
    public function lecture_destroy($id)
    {
        $Lecture = Lecture::where("id", $id)->first();
        $course_content_id = $Lecture->course_content_id;
        
        $CourseContent = CourseContent::where("id", $Lecture->course_content_id)->first();
        $CourseContent->number_of_lecture = $CourseContent->number_of_lecture - 1;
        $CourseContent->minutes = $CourseContent->minutes - $Lecture->minutes;
        $CourseContent->save();

        $Course = Course::where("id", $CourseContent->course_id)->first();
       
        $Course->number_of_lecture = $Course->number_of_lecture - 1;
        $Course->minutes = $Course->minutes - $Lecture->minutes;
        $Course->save();

        $Lecture->delete();
    
        return redirect()->route('admin.course_content.show', $course_content_id)->with('success','Lecture deleted successfully');
    }

    public function getVideoDuration($videoPath)
    {
        $video = FFMpeg::open($videoPath);
        $duration = $video->getDurationInSeconds();
        $minutes = $duration / 60;

        return $minutes;
    }
}
