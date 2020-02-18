<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\CompanyTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Company::select(
            'companies_translation.name',
            'companies_translation.language_id',
            'companies.id',
            'companies.logo',
            'companies.status',
            'companies.created_at'
        )->leftJoin('companies_translation', 'companies_translation.company_id', 'companies.id')
            ->where('companies_translation.language_id', $this->languageId);

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search by name
            if ($request->has('search') && !empty($request->search)) {
                $companies = $companies->where('companies_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $companies = $companies->where('status', 1);
                        break;

                    case 'inactive':
                        $companies = $companies->where('status', 0);
                        break;
                }
            }
            $companies = $companies->orderBy('companies.id', 'DESC');

            $companies = $companies->paginate($this->perPage);
            $data = $companies->items();
            $total = $companies->total();


            return response()->json([
                'companies' => $data,
                'total' => $total
            ]);
        }

        // Get drop down list
        $companies = $companies->orderBy('companies_translation.name', 'ASC');
        $companies = $companies->get();

        return response()->json([
            'companies' => $companies,
            'total' => $companies->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company();
        $company->logo = $request->has('logo') ? $request->logo : '';
        $company->status = $request->has('status') ? $request->status : 0;
        $company->save();

        $companyTranslation = new CompanyTranslation();
        $companyTranslation->company_id = $company->id;
        $companyTranslation->language_id = $this->languageId;
        $companyTranslation->name = $request->name;
        $companyTranslation->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Create if not exists
        CompanyTranslation::firstOrCreate([
            'language_id' => $this->languageId,
            'company_id' => $id
        ],
            [
                'name' => ''
            ]
        );

        $company = Company::select(
            'companies_translation.name',
            'companies_translation.language_id',
            'companies.id',
            'companies.logo',
            'companies.status',
            'companies.created_at'
        )->leftJoin('companies_translation', 'companies_translation.company_id', 'companies.id')
            ->where('companies_translation.language_id', $this->languageId)
            ->where('companies_translation.company_id', $id)
            ->first();

        return response()->json([
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $request->has('logo') ? $company->logo = $request->logo : null;
        $company->save();

        // Find the company translation
        $companyTranslation = CompanyTranslation::where([
            'company_id' => $id,
            'language_id' => $this->languageId
        ])->first();

        $request->has('name') ? $companyTranslation->name = $request->name : null;

        $companyTranslation->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(['success' => true]);
    }
}
