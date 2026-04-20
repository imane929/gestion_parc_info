<?php

namespace App\Mail;

use App\Models\DemandeAcces;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccesRejeteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DemandeAcces $demande
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande d\'accès a été refusée - AssetFlow',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.acces-rejete',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
