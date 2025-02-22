<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course_progress(){
        return $this->hasMany(CourseProgress::class)->where("user_id", auth("api")->user() ? auth("api")->user()->id : 0);
    }

    public function getVideoUrlAttribute($val)
    {

        return  asset($val);
    }
    public function getFileAttribute($val)
    {

        return  asset($val);
    }

    function getMinutesAttribute($val){
        //return
        return ceil($val);
    }

}
