<?php

namespace App\Http\Controllers\Dealership;

use App\Dealership;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealershipDropdownController extends Controller
{
    public function index(){
        $dealerships = Dealership::select(
            'dealerships.id',
            'dealerships_translation.name',
            'dealerships_translation.language_id'
        )->leftJoin('dealerships_translation', function($dealershipT){
            $dealershipT->on('dealerships.id', '=', 'dealerships_translation.dealership_id');
            $dealershipT->where('dealerships_translation.language_id', $this->languageId);
        })->where('dealerships.status', 1) // Onyly active dealership
            ->get();

        return response()->json([
            'dealership' => $dealerships,
            'total' => $dealerships->count()
        ]);
    }
}
