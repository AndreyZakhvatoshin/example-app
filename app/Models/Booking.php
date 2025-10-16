<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'start_time',
        'end_time',
        'name',
        'phone',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
