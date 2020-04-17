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
        'country_code',
        'iso_3166_2',
        'iso_3166_3',
        'driver_seating_position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions(){
        return $this->hasMany(Country::class,'id', 'country_id');
    }
}
