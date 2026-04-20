@php
    $links = [
        ['route' => 'admin.dashboard.utilisateur', 'pattern' => 'admin.dashboard.utilisateur', 'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['route' => 'admin.my-assets', 'pattern' => 'admin.my-assets', 'icon' => 'laptop_mac', 'label' => 'My Assets'],
        ['route' => 'admin.tickets.index', 'pattern' => 'admin.tickets.*', 'icon' => 'support_agent', 'label' => 'My Tickets'],
        ['route' => 'admin.tickets.create', 'pattern' => 'admin.tickets.create', 'icon' => 'add_circle', 'label' => 'Create Ticket'],
    ];
@endphp

<div class="flex h-full flex-col px-4 py-6">
    <div class="flex items-center gap-3 px-2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-brand-700 text-white shadow-lg">
            <span class="material-symbols-outlined">person</span>
        </div>
        <div>
            <p class="text-lg font-black tracking-tight text-slate-900 dark:text-white">AssetFlow</p>
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-slate-400">User Space</p>
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
