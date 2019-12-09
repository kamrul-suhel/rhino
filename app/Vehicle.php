<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'driver_seating_position_left_image',
        'driver_seating_position_right_image'
    ];


    /**
     * Belong to brand
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(){
        return $this->belongsTo(Brand::class, 'vehicle_id', 'id');
    }

}
