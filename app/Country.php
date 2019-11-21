<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * Table
     * @var string
     */
    protected $table = 'countries';

    /**
     * Fillable attribute
     * Mass assignment
     * @var array
     */
    protected $fillable = [
        'name',
        'capital',
        'citizenship',
        'country_code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'region_code',
        'sub_region_code',
        'eea',
        'calling_code',
        'currency_symbol',
        'flag',
        'driver_seating_position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions(){
        return $this->hasMany(Country::class,'id', 'country_id');
    }
}
