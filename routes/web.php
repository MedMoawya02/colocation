<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('registerForm');
Route::post('/register/store', [RegisterController::class, 'store'])->name('registerUser');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('loginForm');
Route::post('/login/store', [LoginController::class, 'store'])->name('loginCheck');

// Logout (protégé)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    
    // ==================== COLOCATIONS ====================
    Route::get('/colocation', [ColocationController::class, 'index'])->name('colocationPage');
    Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocationCreate');
    Route::post('/colocation/store', [ColocationController::class, 'store'])->name('colocationStore');
    Route::patch('/colocation/{colocation}/close', [ColocationController::class, 'close'])->name('colocation.close');
    
    // ==================== DÉPENSES ====================
    Route::post('/depense/{colocation}/store', [ExpenseController::class, 'store'])->name('depense.store');
    Route::delete('/depense/{id}/destroy', [ExpenseController::class, 'destroy'])->name('depense.destroy');
    Route::post('/expense/{expense}/mark-paid', [ExpenseController::class, 'payee'])->name('expense.markPaid');
    
    // ==================== INVITATIONS ====================
    Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'send'])->name('colocation.invite');
    
    // ==================== ADMIN ====================
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::patch('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.usersBan');
        Route::patch('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.usersUnban');
    });
    
});

// ==================== INVITATION ACCEPT (Public) ====================
// Cette route doit être en dehors du middleware auth pour permettre l'acceptation sans connexion
Route::get('/invitation/accept/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');