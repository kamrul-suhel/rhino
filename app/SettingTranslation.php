<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'settings_translation';

    /**
     * Fillable attribute
     * @var array
     */
    protected $fillable = [
        'label',
        'translation'
    ];
}
