<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nom,
        public string $email,
        public string $sujet,
        public string $message
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact depuis le site web: ' . $this->sujet,
            from: new Address('assetflow.app@gmail.com', 'AssetFlow'),
            replyTo: [
                new Address($this->email, $this->nom),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
