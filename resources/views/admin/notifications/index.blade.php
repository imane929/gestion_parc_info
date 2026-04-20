@extends('layouts.admin-new')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Notifications</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Restez informé des alertes et annonces du système</p>
    </div>
    <div class="flex gap-2">
        <button type="button" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2" id="markAllRead">
            <span class="material-symbols-outlined text-lg">done_all</span>
            Tout marquer comme lu
        </button>
        <button type="button" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2" id="deleteAllRead">
            <span class="material-symbols-outlined text-lg">delete_sweep</span>
            Supprimer les lus
        </button>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('admin.notifications.index') }}" class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 mb-6">
    <div class="flex flex-wrap gap-3">
        <select name="type" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200" id="filterType">
            <option value="">Tous les types</option>
            <option value="ticket_created" @selected(request('type') === 'ticket_created')>Ticket créé</option>
            <option value="ticket_assigned" @selected(request('type') === 'ticket_assigned')>Ticket assigné</option>
            <option value="ticket_updated" @selected(request('type') === 'ticket_updated')>Ticket mis à jour</option>
            <option value="ticket_resolved" @selected(request('type') === 'ticket_resolved')>Ticket résolu</option>
            <option value="maintenance_due" @selected(request('type') === 'maintenance_due')>Maintenance prévue</option>
            <option value="license_expiring" @selected(request('type') === 'license_expiring')>Licence expirante</option>
            <option value="warranty_expiring" @selected(request('type') === 'warranty_expiring')>Garantie expirante</option>
            <option value="contract_expiring" @selected(request('type') === 'contract_expiring')>Contrat expirant</option>
        </select>
        <select name="lu" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200" id="filterStatus">
            <option value="">Tous les statuts</option>
            <option value="0" @selected(request('lu') === '0')>Non lu</option>
            <option value="1" @selected(request('lu') === '1')>Lu</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors" id="applyFilters">
            <span class="material-symbols-outlined text-lg me-1">filter_list</span>
            Appliquer
        </button>
    </div>
</form>

<!-- Notifications List -->
<div class="space-y-3">
    @forelse($notifications as $notification)
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow {{ !$notification->lu_at ? 'border-l-4 border-l-blue-500' : '' }}" data-id="{{ $notification->id }}" data-url="{{ $notification->meta['url'] ?? '#' }}">
        <div class="flex items-start gap-4">
            <!-- Icon -->
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                @switch($notification->type)
                    @case('ticket_created') bg-blue-100 text-blue-600 @break
                    @case('ticket_assigned') bg-green-100 text-green-600 @break
                    @case('ticket_updated') bg-amber-100 text-amber-600 @break
                    @case('ticket_resolved') bg-emerald-100 text-emerald-600 @break
                    @case('maintenance_due') bg-cyan-100 text-cyan-600 @break
                    @case('license_expiring') bg-orange-100 text-orange-600 @break
                    @case('warranty_expiring') bg-red-100 text-red-600 @break
                    @case('contract_expiring') bg-purple-100 text-purple-600 @break
                    @default bg-slate-100 text-slate-600
                @endswitch
            ">
                <span class="material-symbols-outlined">
                    @switch($notification->type)
                        @case('ticket_created') confirmation_number @break
                        @case('ticket_assigned') assign @break
                        @case('ticket_updated') edit @break
                        @case('ticket_resolved') check_circle @break
                        @case('maintenance_due') build @break
                        @case('license_expiring') key @break
                        @case('warranty_expiring') shield @break
                        @case('contract_expiring') description @break
                        @default notifications
                    @endswitch
                </span>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <h6 class="font-semibold text-slate-900 dark:text-white">{{ $notification->titre }}</h6>
                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-2">{{ $notification->message }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-400">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        {{ $notification->created_at->format('d/m/Y H:i') }}
                    </span>
                    <div class="flex gap-1">
                        @if(!$notification->lu_at)
                        <button class="p-2 text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors mark-read" data-id="{{ $notification->id }}" title="Marquer comme lu">
                            <span class="material-symbols-outlined">check</span>
                        </button>
                        @endif
                        <button class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors delete-notification" data-id="{{ $notification->id }}" title="Supprimer">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-12 text-center">
        <div class="w-20 h-20 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-4xl text-slate-400">notifications_none</span>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Aucune notification</h3>
        <p class="text-slate-500 dark:text-slate-400">Vous êtes à jour ! Revenez plus tard pour de nouveaux éléments.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6 flex justify-end">
    {{ $notifications->links() }}
</div>

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function sendNotificationAction(url, method = 'POST') {
        return fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then((response) => {
            if (!response.ok) {
                throw new Error('Action failed');
            }
            return response.json();
        });
    }

    document.querySelectorAll('.mark-read').forEach((button) => {
        button.addEventListener('click', function () {
            const notificationId = this.dataset.id;
            const url = '{{ route('admin.notifications.index') }}/' + notificationId + '/marquer-lue';
            sendNotificationAction(url, 'POST').then(() => location.reload());
        });
    });

    document.querySelectorAll('.delete-notification').forEach((button) => {
        button.addEventListener('click', function () {
            const notificationId = this.dataset.id;
            const url = '{{ route('admin.notifications.index') }}/' + notificationId;
            sendNotificationAction(url, 'DELETE').then(() => location.reload());
        });
    });

    document.getElementById('markAllRead')?.addEventListener('click', function () {
        sendNotificationAction('{{ route('admin.notifications.marquer-toutes-lues') }}', 'POST').then(() => location.reload());
    });

    document.getElementById('deleteAllRead')?.addEventListener('click', function () {
        if (!confirm('Supprimer toutes les notifications lues ?')) {
            return;
        }
        sendNotificationAction('{{ route('admin.notifications.supprimer-lues') }}', 'POST').then(() => location.reload());
    });
</script>
@endpush
@endsection

