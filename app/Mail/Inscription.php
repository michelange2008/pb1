<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class Inscription extends Mailable
{
    use Queueable, SerializesModels;

    public $nouveau_user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $nouveau_user)
    {
        $this->nouveau_user = $nouveau_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Nouvelle demande d'identifiant Panse-Bêtes")
                    ->view('admin.mail_inscription');
    }
}
