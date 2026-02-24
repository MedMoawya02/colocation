<?php

use App\Http\Controllers\ColocationController;
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
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

//member
Route::get('/colocation',[ColocationController::class,'index'])->name('colocationPage');
Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocationCreate');
Route::post('/colocation/store', [ColocationController::class, 'store'])->name('colocationStore');
