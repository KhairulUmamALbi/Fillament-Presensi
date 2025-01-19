<?php

namespace App\Livewire;

use App\Models\schedules;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Presensi extends Component
{
    public function render()
    {
        $schedules = Schedules::where('user_id', Auth::user()->id)->first();

        return view('livewire.presensi', [
            'schedules' => $schedules,
        ]);
    }
}
