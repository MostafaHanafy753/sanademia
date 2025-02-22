<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    { 
        $Banners = Banner::orderBy("id","desc")->get();
        return view('admin.banners.index', compact('Banners'));
    }
     
    public function create()
    {
        return view('admin.banners.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            // 'title' => 'required|unique:banners,title',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);
    
        $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);

        Banner::create([
            'title' => $request->title,
            'image' => $imageName,
        ]);
     
        return redirect()->route('admin.banner.index')->with('success','Banner created successfully.');
    }
     
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit',compact('banner'));
    }
    
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            // 'title' => 'required|unique:banners,title,'.$banner->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg'
        ]);

        $bannerArr = [
            'title' => $request->title,
        ];
        
        if($request->hasFile('image'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);     
            $bannerArr['image'] = $imageName;                    
        } 

        $banner->update($bannerArr);
    
        return redirect()->route('admin.banner.index')->with('success','Banner updated successfully');
    }
    
    public function destroy(Banner $banner)
    {
        $banner->delete();
    
        return redirect()->route('admin.banner.index')->with('success','Banner deleted successfully');
    }
}
