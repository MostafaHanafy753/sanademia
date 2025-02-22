<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
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
        $courses = Course::all();
        return view('admin.auth.course_registration', compact('courses'));
    }

    public function postCourseRegistration(Request $request)
    {
        $validated = $request->validate([
            'courses' => [
                'required',
                function ($attribute, $value, $fail) {
                    $ids = explode(',', $value);
                    if (!empty($ids) && !collect($ids)->every(fn($id) => is_numeric($id))) {
                        $fail('The ' . $attribute . ' field must contain only valid numeric IDs.');
                        return;
                    }
                    $existingIds = Course::query()->whereIn('id', $ids)->pluck('id')->toArray();
                    $missingIds = array_diff($ids, $existingIds);
                    if (!empty($missingIds)) {
                        $fail('The following course IDs are invalid: ' . implode(', ', $missingIds));
                    }
                }
            ],
            'full_name' => 'required|string',
            'phone_no' => 'required|numeric',
            'course_mode' => 'required|in:online,in_class'
        ]);
        CourseRegistration::query()->create($validated);
        return redirect()->back()->with('success','course registration submitted successfully');
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
            return redirect()->intended('admin/dashboard')->withSuccess('You have Successfully loggedin');
        }

        return redirect("/")->withError('You have entered invalid credentials');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
