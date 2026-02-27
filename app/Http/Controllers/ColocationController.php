<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index()
    {
        $colocation = auth()->user()->activeColocation();
        $categories=Category::all();
        $balances = $colocation ? $colocation->balances() : [];
        return view('colocation.addColocation', compact('colocation','categories','balances'));
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

    public function close(Colocation $colocation){
        $user=auth()->user();
        $role=$colocation->users()->where('user_id',$user->id)->first()?->pivot;
        if(!$role||$role->role!=='owner'){
             return redirect()->back()->with('error', 'Vous n’êtes pas autorisé à clôturer cette colocation.');
        }
        $colocation->update(['isActive'=>false]);
          return redirect()->route('colocationPage')
        ->with('success', 'La colocation a été clôturée. Vous pouvez créer une nouvelle colocation.');
    }
}
