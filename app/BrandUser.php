<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'brand_user';

    /**
     * @var array
     */
    protected $fillable = [
        'new',
        'used'
    ];
}
