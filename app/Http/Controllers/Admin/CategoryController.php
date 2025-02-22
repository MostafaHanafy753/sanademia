<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    { 
        $categories = Category::orderBy("id","desc")->get();
        return view('admin.categories.index', compact('categories'));
    }
     
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);
    
        $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);

        Category::create([
            'name' => $request->name,
            'color_code' => $request->color_code,
            'image' => $imageName,
        ]);
     
        return redirect()->route('admin.category.index')->with('success','Category created successfully.');
    }
     
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg'
        ]);

        $categoryArr = [
            'name' => $request->name,
            'color_code' => $request->color_code,
        ];
        
        if($request->hasFile('image'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);     
            $categoryArr['image'] = $imageName;                    
        } 

        $category->update($categoryArr);
    
        return redirect()->route('admin.category.index')->with('success','Category updated successfully');
    }
    
    public function destroy(Category $category)
    {
        $category->delete();
    
        return redirect()->route('admin.category.index')->with('success','Category deleted successfully');
    }
}
