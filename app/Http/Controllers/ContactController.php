<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Save message to database
        $contactMessage = ContactMessage::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'sujet' => $request->sujet,
            'message' => $request->message,
            'statut' => 'nouveau',
        ]);

        // Try to send email
        try {
            Mail::to('assetflow.app@gmail.com')->send(new ContactMail(
                $request->nom,
                $request->email,
                $request->sujet,
                $request->message
            ));
        } catch (\Exception $e) {
            // Email failed but message is saved in database
            \Log::error('Contact form email error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
