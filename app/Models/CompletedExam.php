<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedExam extends Model
{
    use HasFactory;
    
    protected $guarded = []; 
    
    public function getPercentageAttribute($val){
        return number_format($val, 2);
    }
}
