<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestRequest extends Model
{
    protected $fillable = [
        'guest_session_id',
        'user_id',
        'endpoint',
        'method',
        'request_data',
        'timestamp',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(GuestSession::class);
    }
}

