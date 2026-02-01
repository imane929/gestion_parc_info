@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Votre tableau de bord utilisateur</p>
    </div>
    
    <!-- User-specific content here -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">Vos équipements attribués</h2>
        <p class="text-gray-500">Aucun équipement attribué pour le moment.</p>
    </div>
</div>
@endsection