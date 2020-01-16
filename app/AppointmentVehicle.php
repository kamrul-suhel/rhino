<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentVehicle extends Model
{
    protected $table = 'appointment_vehicles';

    protected $fillable = [
      'vehicle_condition'
    ];
}
