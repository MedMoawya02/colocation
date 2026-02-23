<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }
    public function store(StoreUserRequest $request){
        $user=User::create([
            'name'=>$request->nomComplet,
            'email'=>$request->email,
            'password'=>Hash::make($request->password) ,
        ]);
        if(User::count()==1){
            $user->role="admin";
            $user->save();
        }
        return redirect()->route('loginForm')->with('success', 'Compte créé avec succès !');
    }
}
