<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // login
    public function loginUser(Request $request) {
        try {
            // validate request
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            // attempt login
            if(!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){
                Log::warning("Invalid Credential"); // log warning
                return response()->json([], 401); // response 401
            }

            return response()->json([], 200); // response 200
        } catch (\Throwable $th) {
            Log::error($th->getMessage()); // log errors
            return response()->json([], 500); // response 500
        }
    }

    //logout
    public function logout() {
        Auth::logout(); // Logs out the authenticated user

        // Invalidate the session and regenerate the token
        session()->invalidate();
        session()->regenerateToken();

        // Redirect to login page or wherever you want
        return redirect('/');
    }
    }
