<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    /**
     * Status filed option
     */
    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_CANCELED = 2;
    const STATUS_NOT_AVAILABLE = 3;

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
