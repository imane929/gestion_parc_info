@php
    $links = [
        ['route' => 'admin.dashboard.technicien', 'pattern' => 'admin.dashboard.technicien', 'icon' => 'engineering', 'label' => 'Dashboard'],
        ['route' => 'admin.tickets.index', 'pattern' => 'admin.tickets.*', 'icon' => 'confirmation_number', 'label' => 'My Tickets'],
        ['route' => 'admin.interventions.index', 'pattern' => 'admin.interventions.*', 'icon' => 'construction', 'label' => 'Interventions'],
        ['route' => 'admin.maintenance-history', 'pattern' => 'admin.maintenance-history', 'icon' => 'history', 'label' => 'Maintenance History'],
    ];
@endphp

<div class="flex h-full flex-col px-4 py-6">
    <div class="flex items-center gap-3 px-2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg">
            <span class="material-symbols-outlined">precision_manufacturing</span>
        </div>
        <div>
            <p class="text-lg font-black tracking-tight text-slate-900 dark:text-white">AssetFlow</p>
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-slate-400">Technician Desk</p>
        </div>
    </div>

    <nav class="mt-8 space-y-2">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['pattern']) ? 'bg-brand-50 text-brand-700 dark:bg-brand-950/70 dark:text-brand-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900' }} flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold transition">
                <span class="material-symbols-outlined">{{ $link['icon'] }}</span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
