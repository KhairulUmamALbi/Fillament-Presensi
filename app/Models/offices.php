<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
class offices extends Model
{
    //
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
    ];
}
