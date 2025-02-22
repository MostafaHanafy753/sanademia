<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\RegistrationFormCourse;
use Illuminate\Http\Request;
use App\Models\Contact;
use DataTables;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $requests = CourseRegistration::orderBy("id", "desc")->get();
        return view('admin.course_registration.index', compact('requests'));
    }

    public function destroy(Contact $Contact)
    {
        $Contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Contact deleted successfully');
    }

    public function loadCourses(Request $request)
    {
        $courses = explode(',', $request->courses);
        $courses = RegistrationFormCourse::query()->whereIn('id', $courses)->get();
        return response()->json($courses);
    }

    public function register_to_course(Request $request, $slug)
    {
        $course = RegistrationFormCourse::where('slug', $slug)
            ->when($request->id, function ($query) use ($request) {
                $query->orWhere('id', $request->id);
            })
            ->first();
        return view('frontend.course_registration', compact('course'));
    }

    public function test(){
        return view('frontend.test');
    }
}
