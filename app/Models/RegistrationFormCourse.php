<?php

namespace App\Models;

use App\Traits\ImagesOperations;
use Illuminate\Database\Eloquent\Model;

class RegistrationFormCourse extends Model
{
    protected $guarded = [];

    public function getBannerAttribute($val)
    {
        return $val != "" ? asset($val) : "";
    }

}
