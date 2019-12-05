<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'dealership_id',
        'type_id',
        'start',
        'end'
    ];
}
