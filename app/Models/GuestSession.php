<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuestSession extends Model
{
    protected $fillable = [
        'ip_address',
        'device_hash',
        'os_type',
        'user_agent',
        'last_activity',
        'status',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(GuestRequest::class);
    }
}
