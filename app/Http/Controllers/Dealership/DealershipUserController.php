<?php

namespace App\Http\Controllers\Dealership;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DealershipUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($dealershipId)
    {
        $users = User::select(
            'users.*'
        )->where('users.dealership_id', $dealershipId)
            ->get();

        return response()->json([
            'users' => $users,
            'total' => $users->count()
        ]);
    }
}
