<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountyTranslation extends Model
{

    protected $table = 'countries_translation';

    protected $fillable = [
        'name',
        'country_id',
        'language_id'
    ];
}
