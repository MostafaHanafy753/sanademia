<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'courses',
        'full_name',
        'phone_no',
        'course_mode'
    ];
}
