<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// register page
Route::get('/register',[RegisterController::class,'index'])->name('registerForm');

// login page 
Route::get('/login',[LoginController::class,'index'])->name('loginForm');
