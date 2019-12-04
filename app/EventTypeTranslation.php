<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTypeTranslation extends Model
{
    protected $table = 'types_translation';

    protected $fillable = [
        'name',
        'language_id',
        'type_id'
    ];
}
