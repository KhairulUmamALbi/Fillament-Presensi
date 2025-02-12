<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class schedules extends Model
{
    use HasFactory, HasRoles;

    protected $casts = [
        'is_wfa' => 'boolean',
        'is_banned' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'shifts_id',
        'is_wfa',
        'offices_id',
        'end_time',
        'is_banned',
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
