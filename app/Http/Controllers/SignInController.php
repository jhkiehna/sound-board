<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
    public function store(SignInRequest $request)
    {
        $user = User::where('name', $request->name)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->signIn();

                return (new UserResource($user))->response()->setStatusCode(201);
            }
        }

        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    public function destroy(Request $request)
    {
        $request->user()->signOut();

        return response()->json(["message" => "User Signed Out"], 200);
    }
}
