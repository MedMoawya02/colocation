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
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email n exsite pas');
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
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('loginForm')
            ->with('error', 'Connectez-vous pour accepter l’invitation.');
    }

    $invitation = Invitation::where('token', $token)
        ->with('colocation')
        ->firstOrFail();

    // Vérifier que l'email correspond
    if ($user->email !== $invitation->email) {
        return redirect()->route('colocationPage')
            ->with('error', 'Cette invitation ne vous appartient pas.');
    }

    // Si invitation déjà acceptée
    if ($invitation->status === 'accepted') {
        return redirect()->route('colocationPage')
            ->with('info', 'Vous avez déjà accepté cette invitation.');
    }

    $colocation = $invitation->colocation;

    // Vérifier si le membre est déjà dans la colocation
    if (!$user->colocations()->where('colocation_id', $colocation->id)->exists()) {
        $user->colocations()->attach($colocation->id, [
            'role' => 'member',
            'left_at' => null
        ]);
    }

    // Mettre à jour le status de l'invitation
    $invitation->update(['status' => 'accepted']);

    return redirect()->route('colocationPage')
        ->with('success', 'Vous avez rejoint la colocation !');
}
}
