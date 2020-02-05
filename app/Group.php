<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'groups';

    /**
     * @var array
     */
    protected $fillable = [
        'logo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealerships()
    {
        return $this->hasMany(Dealership::class, 'dealership_id', 'id');
    }

    public function groupTranslation(){
        return $this->hasOne(GroupTranslation::class, 'group_id', 'id');
    }
}
