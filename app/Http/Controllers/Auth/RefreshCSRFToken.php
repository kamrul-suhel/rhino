<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshCSRFToken extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshCSRFToken()
    {
        $csrfToken = csrf_token();

        return response()->json([
            'success' => true,
            'csrfToken' => $csrfToken
        ]);
    }
}
