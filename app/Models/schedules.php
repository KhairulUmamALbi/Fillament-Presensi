<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shifts_id',
        // 'office_id',
        // 'latitude',
        // 'longitude',
        // 'schedule_latitude',
        // 'schedule_longitude',
        // 'schedule_start_time',
        // 'schedule_end_time',
        // 'start_time',
        'is_wfa',
        'offices_id',
        'end_time',
    ];

    //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shifts(): BelongsTo
    {
        return $this->belongsTo(shifts::class);
    }

    public function offices(): BelongsTo
    {
        return $this->belongsTo(offices::class);
    }
}
