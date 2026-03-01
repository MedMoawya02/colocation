<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user=User::where('email',$credentials['email'])->first();
        if($user->is_banned){
            return back()->withErrors(['email' => 'Votre compte a été banni.']);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(auth()->user()->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('colocationPage');
        }
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginForm');
    }
}
