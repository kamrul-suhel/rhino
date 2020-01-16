<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'bring_guest',
        'guest_changing_car',
        'start',
        'end',
        'part_ex_vrm',
        'part_ex_vehicle',
        'part_ex_distance',
        'part_ex_settlement',
        'is_canceled'
    ];
}