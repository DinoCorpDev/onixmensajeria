<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            try {
                $request->session()->regenerate();
 
                $user = Auth::user();
                return response()->json(['status' => 200,'data' => $user], 200);
            } catch (\Throwable $th) {
                return response()->json(['status' => 400,'statusText' => $th], 400);
            }
        }else{
            return response()->json(['status' => 400,'statusText' => 'Error en servidor'], 400);
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(){
        Auth::logout();        
        return response()->json(['status' => 200,'statusText' => 'Sesion Cerrada'], 200);
    }
}
