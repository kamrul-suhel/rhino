<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleTranslation extends Model
{
    protected $table = 'vehicles_translation';

    protected $fillable = [
        'model',
        'vehicle_id',
        'language_id'
    ];
}
