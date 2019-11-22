<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealership extends Model
{
    /**
     * @var string
     */
    protected $table = 'dealerships';


    protected $fillable = [
        'latitude',
        'longitude',
        'monday_start',
        'monday_end'
    ];


    /**
     * Belong to group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(){
        return $this->belongsTo(Group::class, 'dealership_id', 'id');
    }
}