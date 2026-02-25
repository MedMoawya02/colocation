<?php

use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
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
Route::post('/depense/{colocation}/store', [ExpenseController::class, 'store'])->name('depense.store');
Route::delete('/depense/{id}/destroy', [ExpenseController::class, 'destroy'])->name('depense.destroy');


// Envoyer une invitation à un email pour une colocation spécifique
Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'send'])
     ->name('colocation.invite');
Route::get('/invitation/accept/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');