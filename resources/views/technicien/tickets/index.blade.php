@extends('layouts.technicien')

@section('title', 'Mes Tickets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">Mes Tickets</h1>
        <p class="text-muted mb-0">Gérez tous vos tickets de maintenance</p>
    </div>
    <a href="{{ route('technicien.tickets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Nouveau Ticket
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0">Liste des Tickets</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Équipement</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td>{{ $ticket->titre }}</td>
                        <td>{{ $ticket->equipement->nom ?? 'N/A' }}</td>
                        <td>
                            @if($ticket->priorite == 'haute')
                            <span class="badge badge-danger">Haute</span>
                            @elseif($ticket->priorite == 'moyenne')
                            <span class="badge badge-warning">Moyenne</span>
                            @else
                            <span class="badge badge-success">Basse</span>
                            @endif
                        </td>
                        <td>
                            @if($ticket->statut == 'ouvert')
                            <span class="badge badge-danger">Ouvert</span>
                            @elseif($ticket->statut == 'en_cours')
                            <span class="badge badge-warning">En cours</span>
                            @else
                            <span class="badge badge-success">Terminé</span>
                            @endif
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('technicien.tickets.show', $ticket) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($ticket->statut == 'ouvert' && $ticket->technicien_id == Auth::id())
                                <a href="{{ route('technicien.tickets.start', $ticket) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-play"></i>
                                </a>
                                @elseif($ticket->statut == 'en_cours' && $ticket->technicien_id == Auth::id())
                                <a href="{{ route('technicien.tickets.complete', $ticket) }}" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Aucun ticket trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $tickets->links() }}
    </div>
</div>
@endsection