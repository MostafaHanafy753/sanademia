<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;

class CourseController extends Controller
{
    public function index(Request $request)
    { 
        $Courses = Course::orderBy("id","desc")->get();
        return view('admin.courses.index', compact('Courses'));
    }
     
    public function create()
    {
        $Teachers = Teacher::get();
        $Categories = Category::get();
        return view('admin.courses.create', compact("Teachers", "Categories"));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'teacher_id' => 'required',
            'title' => 'required',
            'video' => 'required',
            // 'hours' => 'required',
            // 'minutes' => 'required',
            // 'number_of_lecture' => 'required',
            'color_code' => 'required',
            'description' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);
    
        $imageName = rand(1111,9999) . time().'.'.$request->banner->extension();  
     
        $request->banner->move(public_path('images'), $imageName);
    
        $videoName = rand(1111,9999) . time().'.'.$request->video->extension();  
     
        $request->video->move(public_path('videos'), $videoName);

        Course::create([
            'category_id' => $request->category_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'video_url' => $videoName,
            // 'hours' => $request->hours,
            // 'minutes' => $request->minutes,
            // 'number_of_lecture' => $request->number_of_lecture,
            'color_code' => $request->color_code,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'what_will_you_learn' => $request->what_will_you_learn,
            'who_this_course_is_for' => $request->who_this_course_is_for,
            'instructor' => $request->instructor,
            'language' => $request->language,
            'price' => $request->price,
            'task_included' => $request->task_included,
            'certificate' => $request->certificate,
            'banner' => $imageName,
        ]);
     
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = 'XXXXXX';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->description,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        return redirect()->route('admin.course.index')->with('success','Course created successfully.');
    }
     
    public function edit(Course $Course)
    {
        $Teachers = Teacher::get();
        $Categories = Category::get();
        return view('admin.courses.edit',compact('Teachers', 'Categories', 'Course'));
    }
    
    public function update(Request $request, Course $Course)
    {
        $request->validate([
            'category_id' => 'required',
            'teacher_id' => 'required',
            'title' => 'required',
            // 'video' => 'required',
            // 'hours' => 'required',
            // 'minutes' => 'required',
            // 'number_of_lecture' => 'required',
            'color_code' => 'required',
            'description' => 'required',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg'
        ]);

        $CourseArr = [
            'category_id' => $request->category_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            // 'hours' => $request->hours,
            // 'minutes' => $request->minutes,
            // 'number_of_lecture' => $request->number_of_lecture,
            'color_code' => $request->color_code,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'what_will_you_learn' => $request->what_will_you_learn,
            'who_this_course_is_for' => $request->who_this_course_is_for,
            'instructor' => $request->instructor,
            'language' => $request->language,
            'price' => $request->price,
            'task_included' => $request->task_included,
            'certificate' => $request->certificate,
        ];
        
        if($request->hasFile('banner'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->banner->extension();  
            $request->banner->move(public_path('images'), $imageName);     
            $CourseArr['banner'] = $imageName;                    
        } 
        
        if($request->hasFile('video'))
        {
            $videoName = rand(1111,9999) . time().'.'.$request->video->extension();  
            $request->video->move(public_path('videos'), $videoName);
            $CourseArr['video_url'] = $videoName;                    
        } 

        $Course->update($CourseArr);
    
        return redirect()->route('admin.course.index')->with('success','Course updated successfully');
    }
    
    public function destroy(Course $Course)
    {
        $Course->delete();
    
        return redirect()->route('admin.course.index')->with('success','Course deleted successfully');
    }
}
