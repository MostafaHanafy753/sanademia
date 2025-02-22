<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];  
    public function getImageAttribute($val)
    {
        return $val != "" ? asset('images/' . $val) : "";
    }
}
