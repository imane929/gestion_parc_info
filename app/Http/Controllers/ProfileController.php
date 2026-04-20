<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $validated = $request->validated();
        
        // Update user fields directly
        $user->prenom = $validated['prenom'];
        $user->nom = $validated['nom'];
        $user->telephone = $validated['telephone'] ?? null;
        
        if ($request->hasFile('photo')) {
            // Delete old photo if present
            if ($user->photo_url) {
                $oldPath = preg_replace('#^/storage/#', '', $user->photo_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo_url = $path;
        }

        $user->save();

        return Redirect::route('admin.profile.edit')->with('success', 'Profile updated successfully');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $request->validate([
            'notif_tickets' => 'boolean',
            'notif_maintenance' => 'boolean',
            'notif_licences' => 'boolean',
            'email_notifications' => 'boolean',
            'langue' => 'in:fr,en,ar',
            'timezone' => 'string',
        ]);

        // Store preferences in session or database
        foreach ($request->except('_token') as $key => $value) {
            session(['preferences.' . $key => $value]);
        }

        // Set locale for current request
        if ($request->has('langue')) {
            app()->setLocale($request->langue);
            session(['locale' => $request->langue]);
        }

        return back()->with('success', 'Preferences updated successfully');
    }

    /**
     * Generate API token.
     */
    public function generateToken(Request $request): RedirectResponse
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
            'permissions' => 'array',
            'expires_at' => 'nullable|integer',
        ]);

        $abilities = $request->permissions ?? ['read'];
        
        $expiresAt = $request->expires_at ? now()->addDays($request->expires_at) : null;
        
        $token = $request->user()->createToken(
            $request->token_name, 
            $abilities,
            $expiresAt
        );

        return back()->with('token', $token->plainTextToken);
    }

    /**
     * Revoke API token.
     */
    public function revokeToken(Request $request, $tokenId): RedirectResponse
    {
        $token = PersonalAccessToken::findOrFail($tokenId);
        
        if ($token->tokenable_id !== $request->user()->id) {
            abort(403);
        }
        
        $token->delete();

        return back()->with('success', 'Token revoked successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
