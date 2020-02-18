<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerateSecurityTokenController extends Controller
{
    /**
     * This method will generate api first layer security token
     *
     */
    public function generateToken(Request $request)
    {
        // Validate security token
        if (!$request->header('RHINO-GENERATE-SECURITY-TOKEN')) {
            return response()->json([
                'success' => false,
                'message' => 'Security code not found'
            ], 403);
        }

        return response()->json([
            'token' => password_hash("rhino_security_code", PASSWORD_DEFAULT)
        ]);
    }
}
