<?php

use App\Http\Controllers\AdminController;
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
Route::get('/register', [RegisterController::class, 'index'])->name('registerForm');
Route::post('/register/store', [RegisterController::class, 'store'])->name('registerUser');

// login page 
Route::get('/login', [LoginController::class, 'index'])->name('loginForm');
Route::post('/login/store', [LoginController::class, 'store'])->name('loginCheck');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//member
Route::get('/colocation', [ColocationController::class, 'index'])->name('colocationPage');
Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocationCreate');
Route::post('/colocation/store', [ColocationController::class, 'store'])->name('colocationStore');
Route::patch('/colocation/{colocation}/close', [ColocationController::class, 'close'])
    ->name('colocation.close');
Route::post('/depense/{colocation}/store', [ExpenseController::class, 'store'])->name('depense.store');
Route::delete('/depense/{id}/destroy', [ExpenseController::class, 'destroy'])->name('depense.destroy');
Route::post('/expense/{expense}/mark-paid', [ExpenseController::class, 'payee'])->name('expense.markPaid');

// Envoyer une invitation à un email pour une colocation spécifique
Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'send'])
    ->name('colocation.invite');
Route::get('/invitation/accept/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');

// Admin
Route::middleware(['auth',])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.usersBan');
    Route::patch('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.usersUnban');
});