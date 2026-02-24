<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ColocationInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        $acceptUrl = url('/invitation/accept/' . $this->invitation->token);

        return $this->subject("Invitation à rejoindre une colocation")
            ->from('no-reply@colocapp.com', 'ColocApp')
            ->html("
                        <p>Bonjour,</p>
                        <p>Vous avez été invité à rejoindre la colocation <strong>{$this->invitation->colocation->name}</strong>.</p>
                        <p>Cliquez sur le lien ci-dessous pour accepter :</p>
                        <p><a href='{$acceptUrl}'>Rejoindre la colocation</a></p>
                    ");
    }
}
