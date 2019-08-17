<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
    public function store(SignInRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->signIn();

                return response()->json([
                    'email' => $user->email,
                    'api_token' => $user->api_token
                ], 201);
            }
        }

        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    public function destroy(Request $request)
    {
        $request->user()->signOut();

        return response("User Signed Out", 200);
    }
}
