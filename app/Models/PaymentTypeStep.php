<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypeStep extends Model
{
    use HasFactory;

    protected $fillable = [        'payment_type_id',
    'title',
    'is_required',
    'is_fixed',
    'input_type',
    'default_value',
    'order'];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    /**
     * Set the default value to null if it's empty.
     */
    public function setDefaultValueAttribute($value)
    {
        $this->attributes['default_value'] = $value ?: null;
    }
}
