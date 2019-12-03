<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealershipTranslation extends Model
{
    protected $table = 'dealerships_translation';

    protected $fillable = [
        'language_id',
        'dealership_id',
        'name',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'address_line_5',
        'address_line_6',
        'postcode'
    ];
}
