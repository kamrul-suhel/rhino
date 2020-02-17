<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';


    /**
     * Greeting field
     * @var array
     */
    const HELLO = 0;
    const HI = 1;

    protected $fillable = [
        'dealership_id',
        'type_id',
        'start',
        'end'
    ];
}
