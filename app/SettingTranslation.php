<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'setting_translations';

    /**
     * Fillable attribute
     * @var array
     */
    protected $fillable = [
        'label',
        'translation'
    ];
}
