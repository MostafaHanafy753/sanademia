<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'image', 'created_by'];

    public function steps()
    {
        return $this->hasMany(PaymentTypeStep::class)->orderBy('order');
    }
}
