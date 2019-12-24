<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyDropdownController extends Controller
{
    public function index(){
        $companies = Company::select(
            'companies_translation.name',
            'companies_translation.language_id',
            'companies.id',
            'companies.logo',
            'companies.created_at'
        )->leftJoin('companies_translation', 'companies_translation.company_id', 'companies.id')
        ->where('companies_translation.language_id', $this->languageId)
        ->where('companies.status', 1); // Only active company

        // Get drop down list
        $companies = $companies->orderBy('companies_translation.name', 'ASC');
        $companies = $companies->get();
        
        return response()->json([
            'companies' => $companies,
            'total' => $companies->count()
        ]);
    }
}
