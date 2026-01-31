@extends('admin.layouts.admin')

@section('title', 'Gestion des Tickets')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Liste des Tickets</h2>
            <p class="text-muted mb-0">Gérez les tickets de maintenance</p>
        </div>
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Ticket
        </a>
    </div>
    
    <!-- Tickets Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Équipement</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                            <th>Technicien</th>
                            <th>Date Ouverture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id }}</td>
                            <td>{{ Str::limit($ticket->titre, 30) }}</td>
                            <td>{{ $ticket->equipement->nom ?? 'N/A' }}</td>
                            <td>
                                @if($ticket->priorite == 'urgente')
                                <span class="badge bg-danger">Urgente</span>
                                @elseif($ticket->priorite == 'haute')
                                <span class="badge bg-warning">Haute</span>
                                @elseif($ticket->priorite == 'moyenne')
                                <span class="badge bg-info">Moyenne</span>
                                @else
                                <span class="badge bg-success">Faible</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->statut == 'ouvert')
                                <span class="badge bg-danger">Ouvert</span>
                                @elseif($ticket->statut == 'en_cours')
                                <span class="badge bg-warning">En cours</span>
                                @elseif($ticket->statut == 'termine')
                                <span class="badge bg-success">Terminé</span>
                                @else
                                <span class="badge bg-secondary">Annulé</span>
                                @endif
                            </td>
                            <td>{{ $ticket->technicien->name ?? 'Non assigné' }}</td>
                            <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Aucun ticket trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($tickets->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection