<?php

namespace App\Mail;

use App\Models\DemandeAcces;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccesApprouveMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DemandeAcces $demande,
        public string $password
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande d\'accès a été approuvée - AssetFlow',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.acces-approuve',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
