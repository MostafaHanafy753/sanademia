<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];   
    
    public function getBannerAttribute($val)
    {
        return $val != "" ? asset('images/' . $val) : "";
    }
    
    public function getVideoUrlAttribute($val)
    {
        return $val != "" ? asset('videos/' . $val) : "";
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function course_contents(){
        return $this->hasMany(CourseContent::class);
    }

    public function enrolls(){
        return $this->hasMany(Enroll::class);
    }
}
