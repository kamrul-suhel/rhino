<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuestLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestLoginController extends Controller
{
    /**
     * Guest user login controller
     * @param GuestLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $guest = Guest::where('unique', $request->uniqueId)
            ->first();

        if ($guest) {
            // Found user, set session variable
            $request->session()->put('uniqueId', $request->uniqueId);

            return response()->json([
                'success' => true,
                'guest' => $guest
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    /**
     * Guest logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logOut()
    {
        session()->forget('uniqueId');
        return response()->json([
            'success' => true
        ]);
    }
}
