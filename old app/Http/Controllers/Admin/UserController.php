<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Enroll;

class UserController extends Controller
{
    public function index(Request $request)
    { 
        $users = User::where("role", "user")->orderBy("id","desc")->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    { 
        $enrolls = Enroll::where("user_id", $user->id)->orderBy("id","desc")->get();
        return view('admin.users.show', compact('user', 'enrolls'));
    }
     
    public function destroy(User $user)
    {
        $user->delete();
    
        return redirect()->route('admin.user.index')->with('success','User deleted successfully');
    }
}
