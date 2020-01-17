<?php

namespace App\Http\Controllers\Auth;

use App\BrandUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserBrandDestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $id)
    {
        $branUser = BrandUser::findOrFail($id);
        $branUser->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
