<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\RegistrationFormCourse;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationFormCourseController extends Controller
{
    use ImagesOperations;

    public function index(Request $request)
    {
        $Courses = RegistrationFormCourse::orderBy("id", "desc")
            ->get();
        return view('admin.course_registration.courses.index', compact('Courses'));
    }

    public function create()
    {
        return view('admin.course_registration.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,svg,webp',
            'price' => 'nullable',
        ]);
        try {

            $imagePath = $this->storeFile($request->banner, 'form_registration/images');
            $slug = Str::slug($request->title);
            $courseWithSameSlug = RegistrationFormCourse::where('slug', $slug)->first();
            if ($courseWithSameSlug) {
                $slug = $slug . '-' . time();
            }

            //make str language same as app lang
            RegistrationFormCourse::create([
                'title' => $request->title,
                'price' => $request->price,
                'banner' => $imagePath,
                'slug' => $slug
            ]);

            return redirect()->route('admin.registration-form.courses.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function edit(RegistrationFormCourse $Course)
    {
        return view('admin.course_registration.courses.edit', compact('Course'));
    }

    public function update(Request $request, RegistrationFormCourse $Course)
    {
        $request->validate([
            'title' => 'required',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'price' => 'nullable',
        ]);
        try {
            $CourseArr = [
                'title' => $request->title,
                'price' => $request->price,
                'slug' => Str::slug($request->title)
            ];

            $courseWithSameSlug = RegistrationFormCourse::where('slug', $CourseArr['slug'])->where('id', '!=', $Course->id)->first();
            if ($courseWithSameSlug) {
                $CourseArr['slug'] = $CourseArr['slug'] . '-' . time();
            }

            if ($request->hasFile('banner')) {
                try {
                    $this->deleteFile($Course->banner);
                } catch (\Exception $e) {
                }

                $CourseArr['banner'] = $this->storeFile($request->banner, 'form_registration/images');
            }

            $Course->update($CourseArr);

            return redirect()->route('admin.registration-form.courses.index')->with('success', 'Course updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function destroy(RegistrationFormCourse $Course)
    {
        $Course->delete();

        return redirect()->route('admin.registration-form.courses.index')->with('success', 'Course deleted successfully');
    }
}
