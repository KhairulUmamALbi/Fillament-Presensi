<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\attendances;


class Map extends Component
{
    public function render()
    {
        $attendances = Attendances::with('user')->get();
        return view('livewire.map',[
            'attendances' => $attendances
        ]);
    }
}
