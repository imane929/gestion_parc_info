<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigurationController extends Controller
{
    public function index()
    {
        $config = [
            'organization_name' => config('app.name', 'Gestion Parc Informatique'),
            'contact_email' => config('mail.from.address', 'contact@parc-informatique.com'),
            'email_notifications' => Cache::get('email_notifications', true),
            'auto_report' => Cache::get('auto_report', 'weekly')
        ];
        
        return view('admin.configuration.index', compact('config'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'email_notifications' => 'required|boolean',
            'auto_report' => 'required|in:daily,weekly,monthly,none',
        ]);

        // Save configuration to cache (i can save to database or .env file if needed)
        foreach ($validated as $key => $value) {
            Cache::forever($key, $value);
        }
                
        return redirect()->route('admin.configuration.index')
            ->with('success', 'Configuration mise à jour avec succès.');
    }
}