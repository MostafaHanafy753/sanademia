<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\RegistrationFormCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->user()) {
            return redirect('admin/dashboard');
        }

        return view('admin.auth.login');
    }

    public function courseRegistration()
    {
        $courses = RegistrationFormCourse::get();
        return view('frontend.course_registration', compact('courses'));
    }

    public function postCourseRegistration(Request $request)
    {

        $validated = $request->validate(
            [
                'courses' => ['required', 'array', 'min:1',],
                'courses.*' => ['required', 'exists:registration_form_courses,id'],
                'full_name' => 'required|string',
                'phone_no' => 'required|numeric',
                'course_mode' => 'required|in:online,in_class'
            ]);

        try {
            $courseRegistration = CourseRegistration::query()->create([
                'full_name' => $validated['full_name'],
                'phone_no' => $validated['phone_no'],
                'course_mode' => $validated['course_mode'],
                'guest_session_id' => Session::get('guest_session_id'),
                'user_id' => Auth::id(),
            ]);

            $courseRegistration->courses()->attach($validated['courses']);

            return redirect()->back()->with('success', 'course registration submitted successfully');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard');
        }

        return redirect("/login")->withError('You have entered invalid credentials');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
