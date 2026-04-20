@extends('layouts.admin-new')

@section('title', 'Modifier le profil')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-on-surface">Modifier le profil</h1>
    <p class="text-sm text-on-surface-variant">Mettez à jour vos informations personnelles</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Profile Preview -->
    <div class="lg:col-span-4">
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/10 sticky top-24">
            <div class="text-center mb-6">
                <div class="relative inline-block">
                    @if(auth()->user()->photo_url)
                        <img src="{{ auth()->user()->photo_url }}" 
                             alt="Avatar" 
                             id="avatarPreview"
                             class="w-28 h-28 rounded-full object-cover mx-auto mb-4 ring-4 ring-primary/20">
                    @else
                        <div id="avatarPreview" class="w-28 h-28 rounded-full mx-auto mb-4 bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-3xl font-bold ring-4 ring-primary/20">
                            {{ auth()->user()->initials ?? 'U' }}
                        </div>
                    @endif
                    <label onclick="document.getElementById('photoInput').click()" class="absolute bottom-2 right-2 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-primary/90 transition-colors shadow-lg">
                        <span class="material-symbols-outlined text-sm">photo_camera</span>
                    </label>
                </div>
                
                <h2 class="text-lg font-bold text-on-surface">{{ auth()->user()->full_name }}</h2>
                <p class="text-sm text-on-surface-variant">{{ auth()->user()->roles->first()->libelle ?? 'User' }}</p>
            </div>
            
            <div class="space-y-3 pt-4 border-t border-outline-variant/10">
                <div class="flex items-center gap-3 text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant">mail</span>
                    <span class="text-on-surface">{{ auth()->user()->email }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant">phone</span>
                    <span class="text-on-surface">{{ auth()->user()->telephone ?? 'Not provided' }}</span>
                </div>
            </div>
            
            <p class="text-xs text-on-surface-variant mt-4 text-center">JPG, PNG, GIF accepted. Max: 2MB</p>
        </div>
    </div>
    
    <!-- Tabs Content -->
    <div class="lg:col-span-8">
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-outline-variant/10 overflow-x-auto">
                <button onclick="showEditTab('info')" id="edit-tab-info" class="edit-tab-btn active px-6 py-4 text-sm font-medium text-primary border-b-2 border-primary whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">person</span>
                    Informations
                </button>
                <button onclick="showEditTab('password')" id="edit-tab-password" class="edit-tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent hover:text-on-surface whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">lock</span>
                    Sécurité
                </button>
                <button onclick="showEditTab('preferences')" id="edit-tab-preferences" class="edit-tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent hover:text-on-surface whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">notifications</span>
                    Préférences
                </button>
            </div>
            
            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Personal Info Tab -->
                <div id="edit-content-info" class="edit-tab-content">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Prénom</label>
                                    <input type="text" name="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" 
                                           class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('prenom') border-error @enderror" required>
                                    @error('prenom')
                                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Nom</label>
                                    <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" 
                                           class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('nom') border-error @enderror" required>
                                    @error('nom')
                                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-2">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" 
                                       class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface/70 cursor-not-allowed" readonly disabled>
                                <p class="text-xs text-on-surface-variant mt-1">Email cannot be changed</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-2">Phone</label>
                                <input type="tel" name="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" 
                                       class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('telephone') border-error @enderror">
                                @error('telephone')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-2">Photo de profil</label>
                                <div class="flex items-center gap-4">
                                    <label for="photoInput" class="flex-1 cursor-pointer">
                                        <div class="px-4 py-3 bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant hover:border-primary transition-colors text-center">
                                            <span class="material-symbols-outlined text-2xl text-on-surface-variant mb-1">upload</span>
                                            <p class="text-sm text-on-surface-variant">Cliquez pour télécharger</p>
                                        </div>
                                    </label>
                                    <input id="photoInput" type="file" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>
                                @error('photo')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-outline-variant/10">
                            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">save</span>
                                Enregistrer
                            </button>
                            <a href="{{ route('admin.profile.show') }}" class="px-6 py-3 text-on-surface-variant hover:text-on-surface transition-colors">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Security Tab -->
                <div id="edit-content-password" class="edit-tab-content hidden">
                    <form method="POST" action="{{ route('admin.profile.update-password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" 
                                       class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('current_password') border-error @enderror" required>
                                @error('current_password')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Nouveau mot de passe</label>
                                    <input type="password" name="password" 
                                           class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('password') border-error @enderror" required>
                                    @error('password')
                                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Confirmer le mot de passe</label>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-primary/5 rounded-xl border border-primary/20">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                                    <div>
                                        <p class="text-sm font-medium text-on-surface mb-1">Recommandations :</p>
                                        <p class="text-xs text-on-surface-variant">Utilisez au moins 8 caractères avec une combinaison de majuscules, minuscules, chiffres et symboles.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-outline-variant/10">
                            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">lock</span>
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Preferences Tab -->
                <div id="edit-content-preferences" class="edit-tab-content hidden">
                    <form method="POST" action="{{ route('admin.profile.update-preferences') }}">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-semibold text-on-surface mb-4">Notifications</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl cursor-pointer hover:bg-surface-container transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-on-surface-variant">confirmation_number</span>
                                            <div>
                                                <p class="text-sm font-medium text-on-surface">Notifications de tickets</p>
                                                <p class="text-xs text-on-surface-variant">Recevoir les mises à jour de vos tickets</p>
                                            </div>
                                        </div>
                                        <input type="checkbox" name="notif_tickets" value="1" @checked(auth()->user()->preferences['notif_tickets'] ?? true) class="w-5 h-5 rounded accent-primary">
                                    </label>
                                    
                                    <label class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl cursor-pointer hover:bg-surface-container transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-on-surface-variant">build</span>
                                            <div>
                                                <p class="text-sm font-medium text-on-surface">Notifications de maintenance</p>
                                                <p class="text-xs text-on-surface-variant">Recevoir des notifications sur la maintenance planifiée</p>
                                            </div>
                                        </div>
                                        <input type="checkbox" name="notif_maintenance" value="1" @checked(auth()->user()->preferences['notif_maintenance'] ?? true) class="w-5 h-5 rounded accent-primary">
                                    </label>
                                    
                                    <label class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl cursor-pointer hover:bg-surface-container transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-on-surface-variant">mail</span>
                                            <div>
                                                <p class="text-sm font-medium text-on-surface">Notifications par e-mail</p>
                                                <p class="text-xs text-on-surface-variant">Recevoir des notifications par e-mail</p>
                                            </div>
                                        </div>
                                        <input type="checkbox" name="email_notifications" value="1" @checked(auth()->user()->preferences['email_notifications'] ?? true) class="w-5 h-5 rounded accent-primary">
                                    </label>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Langue</label>
                                    <select name="langue" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                                        <option value="fr" @selected(auth()->user()->preferences['langue'] ?? 'fr' == 'fr')>Français</option>
                                        <option value="en" @selected(auth()->user()->preferences['langue'] ?? 'fr' == 'en')>Anglais</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-on-surface mb-2">Fuseau horaire</label>
                                    <select name="timezone" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                                        <option value="Africa/Casablanca" @selected(auth()->user()->preferences['timezone'] ?? 'Africa/Casablanca' == 'Africa/Casablanca')>Africa/Casablanca</option>
                                        <option value="Europe/Paris" @selected(auth()->user()->preferences['timezone'] ?? 'Africa/Casablanca' == 'Europe/Paris')>Europe/Paris</option>
                                        <option value="UTC" @selected(auth()->user()->preferences['timezone'] ?? 'Africa/Casablanca' == 'UTC')>UTC</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-outline-variant/10">
                            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">save</span>
                                Enregistrer les préférences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showEditTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.edit-tab-content').forEach(el => el.classList.add('hidden'));
        // Show selected tab content
        document.getElementById('edit-content-' + tabName).classList.remove('hidden');
        
        // Update tab buttons
        document.querySelectorAll('.edit-tab-btn').forEach(el => {
            el.classList.remove('active', 'text-primary', 'border-primary');
            el.classList.add('text-on-surface-variant', 'border-transparent');
        });
        
        const activeTab = document.getElementById('edit-tab-' + tabName);
        activeTab.classList.add('active', 'text-primary', 'border-primary');
        activeTab.classList.remove('text-on-surface-variant', 'border-transparent');
    }
    
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    preview.outerHTML = `<img src="${e.target.result}" id="avatarPreview" class="w-28 h-28 rounded-full object-cover mx-auto mb-4 ring-4 ring-primary/20">`;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .edit-tab-btn.active {
        color: #0058be;
        border-color: #0058be;
    }
    
    input[type="checkbox"] {
        accent-color: #0058be;
    }
</style>
@endsection
