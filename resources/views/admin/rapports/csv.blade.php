ID,Nom,Type,Email,Rôle,Date
@foreach($data as $item)
{{ $item->id }},{{ $item->name ?? $item->nom ?? '' }},{{ $item->type ?? $item->role ?? '' }},{{ $item->email ?? '' }},{{ $item->role ?? '' }},{{ $item->created_at->format('d/m/Y H:i') }}
@endforeach