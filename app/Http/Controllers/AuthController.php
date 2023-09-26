<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TokenRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $explodeEmail = explode('@', $request->email);

        $user = User::query()->create([
            'role_id' => $request->role_id,
            'name' => $explodeEmail[0],
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function token(TokenRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        $user->tokens()?->delete();
        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
