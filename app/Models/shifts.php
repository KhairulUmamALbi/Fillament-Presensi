<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
class shifts extends Model
{
    //
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
    ];
}
