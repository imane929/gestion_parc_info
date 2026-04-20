@extends('layouts.admin-new')

@section('title', 'Messages de Contact')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-on-surface">Messages de Contact</h1>
    <p class="text-sm text-on-surface-variant">Voir et gérer les soumissions du formulaire de contact</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-500">mail</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Total</p>
                <p class="text-2xl font-bold text-on-surface">{{ $messages->total() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500">fiber_new</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Nouveau</p>
                <p class="text-2xl font-bold text-on-surface">{{ $messages->where('statut', 'nouveau')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-500">mark_email_read</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Lu</p>
                <p class="text-2xl font-bold text-on-surface">{{ $messages->where('statut', 'lu')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Messages List -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
    <div class="p-6">
        @forelse($messages as $message)
        <div class="bg-surface-container-low rounded-xl p-5 mb-4 {{ $message->statut === 'nouveau' ? 'border-l-4 border-blue-500' : '' }} hover:bg-surface-container transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold text-lg">
                            {{ substr($message->nom, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h3 class="text-base font-semibold text-on-surface">{{ $message->nom }}</h3>
                            @if($message->statut === 'nouveau')
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-600 text-xs font-medium rounded-full">Nouveau</span>
                            @else
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-600 text-xs font-medium rounded-full">Lu</span>
                            @endif
                        </div>
                        <a href="mailto:{{ $message->email }}" class="text-sm text-primary hover:underline">{{ $message->email }}</a>
                        <p class="text-xs text-on-surface-variant mt-1">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($message->statut === 'nouveau')
                        <a href="{{ route('admin.contact-messages.mark', $message->id) }}" 
                           class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"
                           title="Marquer comme lu">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </a>
                    @endif
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-2 text-on-surface-variant hover:text-error hover:bg-error/10 rounded-lg transition-colors"
                                title="Supprimer"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Sujet</p>
                <p class="text-sm font-semibold text-on-surface mb-3">{{ $message->sujet }}</p>
                
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Message</p>
                <p class="text-sm text-on-surface bg-surface-container-lowest rounded-lg p-4 whitespace-pre-wrap">{{ $message->message }}</p>
            </div>
            
            <div class="mt-4 pt-4 border-t border-outline-variant/10 flex justify-end">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->sujet }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-sm">reply</span>
                    Répondre par Email
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">mail</span>
            <p class="text-on-surface-variant">Aucun message trouvé</p>
        </div>
        @endforelse
        
        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection

