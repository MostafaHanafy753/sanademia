<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\CompletedExam;
use App\Models\CourseProgress;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends BaseController
{

    public function get_exams(Request $request)
    {

        $CourseProgress = CourseProgress::with("course")->groupBy("course_id")
        ->selectRaw('course_id, SUM(completed_minute) as completed_minutes, SUM(remaining_minute) as remaining_minutes')
        ->where("user_id", auth()->user()->id)->get();

        $completed_course_ids = [];
        foreach($CourseProgress as $CourseProgres){
            $Course = Course::where("id", $CourseProgres->course_id)->first();
            if(!empty($Course)){
                if($Course->minutes == $CourseProgres->completed_minutes){
                    $completed_course_ids[] = $CourseProgres->course_id;
                }
            }
        }

        $Exams = Exam::withCount('questions')->whereIn("course_id", $completed_course_ids)->get();

        foreach($Exams as $Exam){
            $Exam->is_completed = 0;
            $CompletedExam = CompletedExam::where("user_id", auth()->user()->id)->where("exam_id", $Exam->id)->first();
            if(!empty($CompletedExam)){
                $Exam->is_completed = 1;
            }
        }
        return $this->sendResponse($Exams, 'Exams get successfully.');
    }

    public function get_questions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $Questions = Question::where("exam_id", $request->exam_id)->inRandomOrder()->get();

        foreach($Questions as $Question){
            $Question->selected_answer = NULL;

            $QuestionAnswer = QuestionAnswer::where("user_id", auth()->user()->id)->where("question_id", $Question->id)->first();
            if(!empty($QuestionAnswer)){
                $Question->selected_answer = $QuestionAnswer->answer;
            }

        }
        return $this->sendResponse($Questions, 'Questions get successfully.');
    }

    public function save_questions_answers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required',
            'question_ids' => 'required|array',
            'question_ids.*' => 'required|exists:questions,id',
            'answers' => 'required|array',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        if(!empty($request->question_ids)){
            $score = 0;
            $total_question = count($request->question_ids);
            foreach($request->question_ids as $key => $question_id){
                $Question = Question::where("id", $question_id)->first();
                $correct = 0;
                if(!empty($Question)){
                    if(isset($request->answers[$key]) && $request->answers[$key] == $Question->correct_ans){
                        $correct = 1;
                        $score += 1;
                    }
                }

                $QuestionAnswer = QuestionAnswer::where("user_id", auth()->user()->id)->where("question_id", $question_id)->first();
                if(empty($QuestionAnswer)){

                    QuestionAnswer::create([
                        "user_id" => auth()->user()->id,
                        "exam_id" => $request->exam_id,
                        "question_id" => $question_id,
                        "answer" => isset($request->answers[$key]) ? $request->answers[$key] : "",
                        "correct" => $correct,
                        "skip" => !isset($request->answers[$key]) || (isset($request->answers[$key]) && $request->answers[$key]) == "" ? 1 : 0,
                    ]);
                } else {
                    $QuestionAnswer->update([
                        "exam_id" => $request->exam_id,
                        "answer" => isset($request->answers[$key]) ? $request->answers[$key] : "",
                        "correct" => $correct,
                        "skip" => !isset($request->answers[$key]) || (isset($request->answers[$key]) && $request->answers[$key]) == "" ? 1 : 0,
                    ]);
                }
            }

            $CompletedExam = CompletedExam::where("user_id", auth()->user()->id)->where("exam_id", $request->exam_id)->first();
            if(empty($CompletedExam)){
                CompletedExam::create([
                    "user_id" => auth()->user()->id,
                    "exam_id" => $request->exam_id,
                    "time" => $request->time,
                    "score" => $score,
                    "total_question" => $total_question,
                    "percentage" => ($score / $total_question) * 100,
                ]);
            } else {
                $CompletedExam->update([
                    "time" => $request->time,
                    "score" => $score,
                    "total_question" => $total_question,
                    "percentage" => ($score / $total_question) * 100,
                ]);
            }
        }

        return $this->sendResponse(NULL, 'Questions answers save successfully.');
    }

    public function exam_result(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $CompletedExam = CompletedExam::where("user_id", auth()->user()->id)->where("exam_id", $request->exam_id)->first();
        $QuestionAnswers = QuestionAnswer::where("user_id", auth()->user()->id)->where("exam_id", $request->exam_id)->get();

        $data['CompletedExam'] = $CompletedExam;
        $data['QuestionAnswers'] = $QuestionAnswers;

        return $this->sendResponse($data, 'Exam result get successfully.');
    }
}
