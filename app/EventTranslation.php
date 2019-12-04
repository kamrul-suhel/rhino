<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model
{
    protected $table = 'events_translation';

    protected $fillable = [
        'name',
        'notes',
        'greeting'
    ];
}
