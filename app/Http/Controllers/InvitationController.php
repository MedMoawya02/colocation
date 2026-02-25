<?php

namespace App\Http\Controllers;

use App\Mail\ColocationInvitation;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate(['email' => 'required|email']);
        $user=User::where('email',$request->email)->first();
        if(!$user){
            return back()->with('error','Email n exsite pas' );
        }

        $token = str::random(22);
        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => $token,
            'status' => 'pending',
        ]);
        Mail::to($request->email)->send(new ColocationInvitation($invitation));
        return back()->with('success', 'Invitation envoyée !');
    }

    public function accept($token)
{
    $user = auth()->user(); // Assure-toi que l'utilisateur est connecté

    if (!$user) {
        return redirect()->route('login')->with('error', 'Connectez-vous pour accepter l’invitation.');
    }

    $invitation = Invitation::where('token', $token)->firstOrFail();

    if ($invitation->status === 'accepted') {
        return redirect()->route('colocationPage')->with('info', 'Vous avez déjà accepté cette invitation.');
    }

    // Mettre la status à accepted
    $invitation->update(['status' => 'accepted']);

    // Ajouter l'utilisateur à la colocation via pivot membership
    $invitation->colocation->users()->attach($user->id, ['role' => 'member', 'left_at' => null]);

    return redirect()->route('colocationPage')->with('success', 'Vous avez rejoint la colocation !');
}
}
