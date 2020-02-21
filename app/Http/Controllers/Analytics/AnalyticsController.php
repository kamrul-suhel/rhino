<?php

namespace App\Http\Controllers\Analytics;

use App\Guest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public function index(Request $request, $eventId)
    {
        $analytics = DB::table('guests')
            ->select(
                'method',
                DB::raw('count(*) as total')
            )
            ->where('guests.event_id', $eventId)
            ->groupBy('method')
            ->pluck('total', 'method');

        $totalGuest = Guest::where('event_id', $eventId)
            ->count();

        $guestInfo = Guest::select('status', DB::raw('count(*) as total'))
            ->where([
                'event_id' => $eventId
            ])->groupBy('status')
            ->pluck('total', 'status');

        $generateLabel = [];
        $guestInfo->map(function($value, $key) use(&$generateLabel){
            switch ($key) {
                case 0:
                    $generateLabel['pending'] = $value;
                    break;
                case 1:
                    $generateLabel['confirmed'] = $value;
                    break;
                case 2:
                    $generateLabel['arrived'] = $value;
                    break;
                case 3:
                    $generateLabel['no_sale'] = $value;
                    break;
                case 4:
                    $generateLabel['sale_made'] = $value;
                    break;

                case 5:
                    $generateLabel['no_show'] = $value;
                    break;

                case 6:
                    $generateLabel['cancel'] = $value;
                    break;

                default:
                    $generateLabel['other'] = $value;
            }
        });

        return response()->json([
            'success' => true,
            'analytics' => $analytics,
            'total_guest' => $totalGuest,
            'guest_info' => $generateLabel
        ]);
    }
}
