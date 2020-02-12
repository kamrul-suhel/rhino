<?php

namespace App\Http\Controllers\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    
    public function index(Request $request)
    {

        dd($request->all() );
        //$analytics 

        return response()->json([
            'success' => true,
            'analytics' => $analytics,
        ]);
    }

}
