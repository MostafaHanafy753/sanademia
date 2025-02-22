<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Question;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index(Request $request)
    { 
        $Exams = Exam::orderBy("id","desc")->get();
        return view('admin.exams.index', compact('Exams'));
    }
     
    public function create()
    {
        $Courses = Course::get();
        return view('admin.exams.create', compact("Courses"));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
        ]);

        Exam::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
        ]);
     
        return redirect()->route('admin.exam.index')->with('success','Exam created successfully.');
    }
     
    public function edit(Exam $Exam)
    {
        $Courses = Course::get();
        return view('admin.exams.edit',compact('Courses', 'Exam'));
    }
    
    public function update(Request $request, Exam $Exam)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
        ]);

        $ExamArr = [
            'course_id' => $request->course_id,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
        ];

        $Exam->update($ExamArr);
    
        return redirect()->route('admin.exam.index')->with('success','Exam updated successfully');
    }
    
    public function destroy(Exam $Exam)
    {
        $Exam->delete();
    
        return redirect()->route('admin.exam.index')->with('success','Exam deleted successfully');
    }

    public function show($id)
    { 
        $Exam = Exam::where("id", $id)->first();
        $Questions = Question::where("exam_id", $id)->orderBy("id","desc")->get();
        return view('admin.questions.index', compact('Exam', 'Questions'));
    }

         
    public function question_create($id)
    {
        return view('admin.questions.create', compact("id"));
    }
    
    public function question_store(Request $request)
    {
        
        $validationArr['title'] = 'required'; 
        if($request->type == "Option"){
            $validationArr['option_1'] = 'required';
            $validationArr['option_2'] = 'required';
            $validationArr['option_3'] = 'required';
            $validationArr['option_4'] = 'required';
            $validationArr['correct'] = 'required';
        } else {
            $validationArr['audio'] = 'required';
        }
        $validationArr['correct'] = 'required';
        $request->validate($validationArr);

        
        $audio = "";
        if($request->hasFile('audio'))
        {
            $audio = rand(1111,9999) . time().'.'.$request->audio->extension();  
            $request->audio->move(public_path('audios'), $audio);     
        } 

        Question::create([
            'exam_id' => $request->exam_id,
            'title' => $request->title,
            'type' => $request->type,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'audio' => $audio,
            'correct_ans' => $request->correct,
        ]);
     
        return redirect()->route('admin.exam.show', $request->exam_id)->with('success','Question created successfully.');
    }
     
    public function question_edit($id)
    {
        $Question = Question::where("id", $id)->first();
        return view('admin.questions.edit',compact('Question'));
    }
    
    public function question_update(Request $request)
    {

        $validationArr['title'] = 'required'; 
        if($request->type == "Option"){
            $validationArr['option_1'] = 'required';
            $validationArr['option_2'] = 'required';
            $validationArr['option_3'] = 'required';
            $validationArr['option_4'] = 'required';
            $validationArr['correct'] = 'required';
        }
        $validationArr['correct'] = 'required';
        $request->validate($validationArr);

        $QuestionArr = [
            'title' => $request->title,
            'type' => $request->type,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'correct_ans' => $request->correct,
        ];

        if($request->hasFile('audio'))
        {
            $audio = rand(1111,9999) . time().'.'.$request->audio->extension();  
            $request->audio->move(public_path('audios'), $audio);
            $QuestionArr['audio'] = $audio;     
        } 

        Question::where("id", $request->id)->update($QuestionArr);

        $Question = Question::where("id", $request->id)->first();
        return redirect()->route('admin.exam.show', $Question->exam_id)->with('success','Question updated successfully');
    }
    
    public function question_delete($id)
    {
        $Question = Question::where("id", $id)->first();
        $exam_id = $Question->exam_id;
        $Question->delete();
    
        return redirect()->route('admin.exam.show', $exam_id)->with('success','Question deleted successfully');
    }
}
