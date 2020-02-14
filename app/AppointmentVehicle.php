<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentVehicle extends Model
{
    /**
     * Condition of vehicle
     * @var string
     */
    const VEHICLE_NEW = 1;
    const VEHICLE_USED = 2;
    const VEHICLE_UNSURE = 3;

    protected $table = 'appointment_vehicles';

    protected $fillable = [
      'vehicle_condition'
    ];
}
