<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data = [];
        $totalUsers = 0;
        $users = User::select(
            'users.id',
            DB::raw("CONCAT(users.firstname ,' ', users.surname) as name"),
            'users.email',
            'users.level'
        );

        if ($request->has('search') && !empty($request->search)) {
            $users = $users->where('users.firstname', 'LIKE', '%' . $request->search . '%')
                ->whereOr('users.surname', 'LIKE', '%'. $request->search . '%')
                ->whereOr('users.email', 'LIKE', '%'. $request->search . '%');
        }

        $data = $users->get();
        $totalUsers = $users->count();

        return response()->json([
            'users' => $data,
            'total' => $totalUsers
        ]);
    }
}
