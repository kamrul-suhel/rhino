<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserDeleteController extends Controller
{
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true
        ]);

    }
}
