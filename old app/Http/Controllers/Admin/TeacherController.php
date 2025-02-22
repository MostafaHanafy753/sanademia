<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request)
    { 
        $teachers = Teacher::orderBy("id","desc")->get();
        return view('admin.teachers.index', compact('teachers'));
    }
     
    public function create()
    {
        return view('admin.teachers.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:teachers,name',
            'mobile_number' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
            'description' => 'required',
        ]);
    
        $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);

        Teacher::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'description' => $request->description,
            'image' => $imageName,
        ]);
     
        return redirect()->route('admin.teacher.index')->with('success','Teacher created successfully.');
    }
     
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit',compact('teacher'));
    }
    
    public function update(Request $request, Teacher $Teacher)
    {
        $request->validate([
            'name' => 'required|unique:teachers,name,'.$Teacher->id,
            'mobile_number' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg'
        ]);

        $TeacherArr = [
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'description' => $request->description,
        ];
        
        if($request->hasFile('image'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);     
            $TeacherArr['image'] = $imageName;                    
        } 

        $Teacher->update($TeacherArr);
    
        return redirect()->route('admin.teacher.index')->with('success','Teacher updated successfully');
    }
    
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
    
        return redirect()->route('admin.teacher.index')->with('success','Teacher deleted successfully');
    }
}
