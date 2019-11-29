<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    /**
     * Name of the table
     * @var string
     */
    protected $table = 'brands_translation';

    protected $fillable = [
        'name',
        'description',
        'brand_id',
        'language_id'
    ];
}
