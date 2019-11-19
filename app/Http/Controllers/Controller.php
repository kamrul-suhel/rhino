<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $languageId = 40; // By default it will be english
    public $perPage = 20;

    public function __construct(Request $request)
    {

        // Set language Id if define
        if($request->has('languageId')){
            $this->languageId = $request->languageId;
        }

        // Set pagination for per page, if exists
        if($request->has('perPage')){
            $this->perPage = $request->perPage;
        }
    }
}
