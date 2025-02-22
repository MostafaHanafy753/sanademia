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
        return $val != "" ? asset($val) : "";
    }

    public function getIntroVideoAttribute($val)
    {

        return  asset($val);
    }
    public function getIntroVideoThumbnailAttribute($val)
    {

        return  asset($val);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function contents(){
        return $this->hasMany(CourseContent::class);
    }

    public function enrolls(){
        return $this->hasMany(Enroll::class);
    }
}
