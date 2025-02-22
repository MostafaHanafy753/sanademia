<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enroll;
use App\Models\Course;

class HomeController extends Controller
{
    public function homePage()
    {
        // dd('hello');
        $user = Auth::user();
        $myCourses = Enroll::where('user_id',$user->id)->get();
        $courses = Course::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user, // we can fetch name, email and dob in this table
                'myCourses' => $myCourses,
                'courses' => $courses,
                'categories' => $categories
            ], 200);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
    }
}
