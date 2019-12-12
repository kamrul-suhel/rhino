<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestDestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);

        $guest->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
