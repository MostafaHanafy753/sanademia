<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(RegistrationFormCourse::class, 'course_registration_courses');
    }
}
