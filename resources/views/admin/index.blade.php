@extends('layouts.admin-new')

@section('title', 'Administration Système')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Administration Système</h1>
        <p class="text-sm text-slate-500 dark:text-gray-400 mt-1">Gérez les utilisateurs, les rôles et les paramètres de {{ config('app.name', 'AssetFlow') }}.</p>
    </div>

    <!-- Admin Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">people</span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['users_count'] }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Utilisateurs</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined text-2xl">person_add</span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['pending_requests'] }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Demandes d'accès</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600">
                    <span class="material-symbols-outlined text-2xl">mail</span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['unread_messages'] }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Messages non lus</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Admin Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.utilisateurs.index') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary transition-all text-center">
            <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-primary mx-auto mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">manage_accounts</span>
            </div>
            <h3 class="font-bold text-slate-800 dark:text-white">Utilisateurs</h3>
            <p class="text-xs text-slate-500 mt-2">Gérer les comptes et accès</p>
        </a>

        <a href="{{ route('admin.roles.index') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-secondary transition-all text-center">
            <div class="w-16 h-16 bg-purple-50 dark:bg-purple-900/20 rounded-2xl flex items-center justify-center text-secondary mx-auto mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">security</span>
            </div>
            <h3 class="font-bold text-slate-800 dark:text-white">Rôles & Droits</h3>
            <p class="text-xs text-slate-500 mt-2">Permissions et groupes</p>
        </a>

        <a href="{{ route('admin.demandes-acces.index') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-orange-500 transition-all text-center">
            <div class="w-16 h-16 bg-orange-50 dark:bg-orange-900/20 rounded-2xl flex items-center justify-center text-orange-600 mx-auto mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">person_add</span>
            </div>
            <h3 class="font-bold text-slate-800 dark:text-white">Inscriptions</h3>
            <p class="text-xs text-slate-500 mt-2">Valider les nouvelles demandes</p>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-slate-400 transition-all text-center">
            <div class="w-16 h-16 bg-slate-50 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-slate-600 dark:text-gray-300 mx-auto mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">settings</span>
            </div>
            <h3 class="font-bold text-slate-800 dark:text-white">Configuration</h3>
            <p class="text-xs text-slate-500 mt-2">Paramètres du système</p>
        </a>
    </div>
</div>
@endsection
