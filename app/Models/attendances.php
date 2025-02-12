<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Carbon\Carbon;

class attendances extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_latitude',
        'schedule_longitude',
        'schedule_start_time',
        'schedule_end_time',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'start_time',
        'end_time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // count attendance if late
    public function isLate(): bool
    {

        $schedule_start_time = Carbon::parse($this->schedule_start_time);
        $start_time = Carbon::parse($this->start_time);

        return $start_time->greaterThan($schedule_start_time); // mebandingkan waktu mulai kerja dengan waktu yang seharusnya mulai kerja
    }

    // make duration of work
    public function Workduration()
    {
        $start_time = Carbon::parse($this->start_time);
        $end_time = Carbon::parse($this->end_time);

        $duration = $start_time->diff($end_time);

        $hours = $duration->h;
        $minutes = $duration->i;

        return "{$hours} jam {$minutes} menit";
    }



}
