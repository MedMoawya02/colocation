<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function store(Request $request){
        $credentials=$request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/');
        }
         return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect',
        ])->onlyInput('email');
    }
}
