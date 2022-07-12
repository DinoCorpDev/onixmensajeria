<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        try {
            $this->validate(request(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $credentials = request(['email', 'password']);


            if (!Auth::attempt($credentials)) {
                return response()->json(['El Correo electrónico o Contraseña no coinciden'], 401);
            }


            $user = request()->user();
            $token = $user->createToken('Personal Access Client');

            return response()->json([
                'user' => $user,
                'access_token' => $token->accessToken,
            ]);

        } catch (ValidationException $e) {
            return response()->json($e->validator->errors());
        }

    }


    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);

    }
}
