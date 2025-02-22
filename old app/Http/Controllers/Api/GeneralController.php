<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\GetInTouch;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Validator;

class GeneralController extends BaseController
{
    public function get_in_touch()
    {
        $GetInTouch = GetInTouch::first(); 
        return $this->sendResponse($GetInTouch, 'Get in touch get successfully.');
    }

    public function about_us()
    {
        $AboutUs = AboutUs::first(); 
        return $this->sendResponse($AboutUs, 'About us get successfully.');
    }
    
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',
            'country_code' => 'required',
            'message' => 'required',
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());       
        }

        $Contact = Contact::create([
            "name" => $request->name,
            "phone_code" => $request->phone_code,
            "phone_number" => $request->phone_number,
            "country_code" => $request->country_code,
            "message" => $request->message,
        ]);
   
        return $this->sendResponse($Contact, 'Contact saved successfully.');
    }
    
    public function home(Request $request)
    {
        $user = NULL;
        if(auth('api')->user())
        {
            $user = User::where("id", auth('api')->user()->id)->first();
        }
        $categories = Category::get();
        $banners = Banner::get();
        $courses = Course::with('teacher','category');
        if($request->search != ""){
            $courses = $courses->where("title", "LIKE", "%". $request->search ."%");
        }
        $courses = $courses->take(12)->get();
   
        $data['user'] = $user;
        $data['categories'] = $categories;
        $data['banners'] = $banners;
        $data['courses'] = $courses;

        return $this->sendResponse($data, 'Home detail get successfully.');
    }
    
    public function notifications(Request $request)
    {
        $Notifications = Notification::get();

        return $this->sendResponse($Notifications, 'Notifications get successfully.');
    }

}
