<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'logo',
        'colour'
    ];

    /**
     * Brand has many region
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions(){
        return $this->hasMany(Region::class, 'brand_id', 'id');
    }
}
