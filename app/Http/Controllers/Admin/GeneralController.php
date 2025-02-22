<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\GetInTouch;

class GeneralController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    
    public function about_us(){
        $AboutUs = AboutUs::first();
        return view('admin.about_us', compact("AboutUs"));
    }

    public function about_us_store(Request $request){
        $request->validate([
            'description' => 'required',
        ]);

        $AboutUs = AboutUs::first();
        if(empty($AboutUs)){
            $AboutUs = new AboutUs;
        }
        $AboutUs->description = $request->description;
        $AboutUs->save();

        return back()->with("success", "About us saved successfully.");
    }
    
    public function get_in_touch(){
        $GetInTouch = GetInTouch::first();
        return view('admin.get_in_touch', compact("GetInTouch"));
    }

    public function get_in_touch_store(Request $request){
        $request->validate([
            'location' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
        ]);

        $GetInTouch = GetInTouch::first();
        if(empty($GetInTouch)){
            $GetInTouch = new GetInTouch;
        }
        $GetInTouch->location = $request->location;
        $GetInTouch->phone_number = $request->phone_number;
        $GetInTouch->email = $request->email;
        $GetInTouch->save();

        return back()->with("success", "Get in touch saved successfully.");
    }
}
