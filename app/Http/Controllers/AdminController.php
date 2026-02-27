<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $bannedUsers = User::where('is_banned', true)->count();
        $totalColocations = Colocation::count();
        $totalExpenses = Expense::count();
        $users = User::all();

        return view('admin.dashboard', compact(
            'totalUsers', 'bannedUsers', 'totalColocations', 'totalExpenses', 'users'
        ));
    }
    public function ban(User $user){
        $user->update(['is_banned'=>true]);
        return back();
    }
    public function unban(User $user){
        $user->update(['is_banned'=>false]);
        return back();
    }
}
