<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'model',
        'driver_seating_position_left_image',
        'driver_seating_position_right_image'
    ];
}
