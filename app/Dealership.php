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

    public function users()
    {   
        return $this->belongsToMany(User::class, 'dealership_id', 'user_id')->withTimestamps();
    }

    public function dealershipTranslation(){
        return $this->hasOne(DealershipTranslation::class,'dealership_id', 'id');
    }
}
