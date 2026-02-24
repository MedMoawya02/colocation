<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index()
    {
        $colocation = auth()->user()->colocations()->with('users')->first();
        return view('colocation.addColocation', compact('colocation'));
    }
    public function create()
    {
        return view('colocation.createColocation');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = auth()->user();
        $colocation = Colocation::create([
            'name' => $request->name,
            'isActive' => true,
        ]);
        $colocation->users()->attach($user->id,['role'=>'owner']);
        return redirect()->route('colocationPage')
                     ->with('success', 'Colocation créée avec succès.');
    }
}
