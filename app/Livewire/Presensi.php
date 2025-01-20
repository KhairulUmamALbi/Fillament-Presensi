<?php

namespace App\Livewire;

use App\Models\attendances;
use App\Models\schedules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Presensi extends Component
{
    public $latitude;

    public $longitude;

    public $insideRadius = false;

    public function render()
    {
        $schedules = Schedules::where('user_id', Auth::user()->id)->first();
        $attendances = Attendances::where('user_id', Auth::user()->id)
            ->whereDate('created_at', date('Y-m-d'))->first();

        return view('livewire.presensi', [
            'schedules' => $schedules,
            'insideRadius' => $this->insideRadius,
            'attendances' => $attendances,
        ]);
    }

    //store location
    public function store()
    {
        $this->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $schedules = Schedules::where('user_id', Auth::user()->id)->first();

        if ($schedules) {
            $attendances = Attendances::where('user_id', Auth::user()->id)
                ->whereDate('created_at', date('Y-m-d'))->first();

            if (! $attendances) {
                $attendances = Attendances::create([
                    'user_id' => Auth::user()->id,
                    'schedule_latitude' => $schedules->offices->latitude,
                    'schedule_longitude' => $schedules->offices->longitude,
                    'schedule_start_time' => $schedules->shifts->start_time,
                    'schedule_end_time' => $schedules->shifts->end_time,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'start_time' => carbon::now()->toTimeString(),
                    'end_time' => carbon::now()->toTimeString(),
                ]);
            } else {
                $attendances->update([
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'end_time' => carbon::now()->toTimeString(),
                ]);
            }

            return redirect()->route('presensi', [
                'latitude' => $this->latitude,
                'insideRadius' => false,
            ]);
        }

    }
}
