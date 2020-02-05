<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
      'logo'
    ];

    public function companyTranslation(){
        return $this->hasOne(CompanyTranslation::class, 'company_id', 'id');
    }
}
