<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigurationController extends Controller
{
    public function index()
    {
        // Get all configurations from database
        $configs = SystemConfiguration::all()->pluck('value', 'key')->toArray();
        
        // Set default values if not in database
        $config = [
            'organization_name' => $configs['organization_name'] ?? 'Gestion Parc Informatique',
            'contact_email' => $configs['contact_email'] ?? 'contact@parc-info.com',
            'email_notifications' => isset($configs['email_notifications']) ? (bool)$configs['email_notifications'] : true,
            'auto_report' => $configs['auto_report'] ?? 'weekly'
        ];
        
        return view('admin.configuration.index', compact('config'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'email_notifications' => 'required|in:0,1',
            'auto_report' => 'required|in:daily,weekly,monthly,none',
        ]);

        // Save configuration to database
        foreach ($validated as $key => $value) {
            SystemConfiguration::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            
            // Also update cache for faster access
            Cache::forever($key, $value);
        }
        
        // Update app name in Laravel config if organization_name is changed
        if (isset($validated['organization_name'])) {
            // This would require updating .env or config file
            // For now, we'll just cache it
            config(['app.name' => $validated['organization_name']]);
        }
                
        return redirect()->route('admin.configuration.index')
            ->with('success', 'Configuration mise à jour avec succès.');
    }
}