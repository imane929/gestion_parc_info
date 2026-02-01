@extends('admin.layouts.admin')

@section('title', 'Détails Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ticket #{{ $ticket->id }} - {{ $ticket->titre }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h6 class="text-muted">Description</h6>
                            <div class="border rounded p-3 bg-light mb-3">
                                {{ $ticket->description }}
                            </div>
                            
                            @if($ticket->solution)
                            <h6 class="text-muted">Solution</h6>
                            <div class="border rounded p-3 bg-light">
                                {{ $ticket->solution }}
                            </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Informations</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Priorité</label>
                                        <p class="form-control-plaintext">
                                            @if($ticket->priorite == 'urgente')
                                            <span class="badge bg-danger">Urgente</span>
                                            @elseif($ticket->priorite == 'haute')
                                            <span class="badge bg-warning">Haute</span>
                                            @elseif($ticket->priorite == 'moyenne')
                                            <span class="badge bg-info">Moyenne</span>
                                            @else
                                            <span class="badge bg-success">Faible</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Statut</label>
                                        <p class="form-control-plaintext">
                                            @if($ticket->statut == 'ouvert')
                                            <span class="badge bg-danger">Ouvert</span>
                                            @elseif($ticket->statut == 'en_cours')
                                            <span class="badge bg-warning">En cours</span>
                                            @elseif($ticket->statut == 'termine')
                                            <span class="badge bg-success">Terminé</span>
                                            @else
                                            <span class="badge bg-secondary">Annulé</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Équipement</label>
                                        <p class="form-control-plaintext">{{ $ticket->equipement->nom ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Technicien assigné</label>
                                        <p class="form-control-plaintext">{{ $ticket->technicien->name ?? 'Non assigné' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Date d'ouverture</label>
                                        <p class="form-control-plaintext">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    
                                    @if($ticket->updated_at != $ticket->created_at)
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Dernière mise à jour</label>
                                        <p class="form-control-plaintext">{{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection