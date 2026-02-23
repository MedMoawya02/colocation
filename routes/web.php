<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// register page
Route::get('/register',[RegisterController::class,'index'])->name('registerForm');
Route::post('/register/store',[RegisterController::class,'store'])->name('registerUser');

// login page 
Route::get('/login',[LoginController::class,'index'])->name('loginForm');
Route::post('/login/store',[LoginController::class,'store'])->name('loginCheck');
