<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    /**
     * Status filed option
     */
    const APPOINTMENT_PENDING = 0;
    const APPOINTMENT_CONFIRMED = 1;
    const APPOINTMENT_CANCELED = 6; // Consistance with guest table
    const APPOINTMENT_NOT_AVAILABLE = 3;
    const APPOINTMENT_BREAK_TIME = 4;

    /**
     * Status identifier
     * @var string
     */
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

    public function vehicles(){
        return $this->hasMany(AppointmentVehicle::class);
    }
}
