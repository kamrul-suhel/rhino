<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'groups_translation';

    protected $fillable = [
        'name'
    ];
}
