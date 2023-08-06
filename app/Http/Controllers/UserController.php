<?php

namespace App\Http\Controllers;

use Database\Seeders\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

            /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        

        if (Auth::attempt($credentials)) {
      
            return redirect()->intended('/Inicio');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

    }

    public function logout(Request $request){

        auth()->logout();
        return redirect()->route('login.signin');

    }

    
}
