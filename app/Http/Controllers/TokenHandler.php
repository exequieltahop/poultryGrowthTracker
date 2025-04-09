<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TokenHandler extends Controller
{
    // generate session
    public function generate_auth_session(Request $request) {
        try {

            //validate request
            $request->validate([
                'username' => 'required'
            ]);

            // make sessions auth
            session([
                'token' => csrf_token(),
                'email' => $request->username
            ]);

            return response()->json([], 200); // return 200

        } catch (\Throwable $th) {
            /**
             * catch and log errors and exceptions
             * then return 500
             */
            Log::error($th->getMessage());
            return response()->json([], 500);
        }
    }
}
