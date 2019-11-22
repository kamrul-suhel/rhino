<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    protected $table = 'companies_translation';

    protected $fillable = [
        'name',
        'description'
    ];
}
