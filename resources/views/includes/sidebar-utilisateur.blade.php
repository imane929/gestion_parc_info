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
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 via-blue-500 to-indigo-600 text-white shadow-lg shadow-cyan-500/25">
            <span class="material-symbols-outlined">person</span>
        </div>
        <div>
            <p class="text-lg font-black tracking-tight text-slate-900 dark:text-white">AssetFlow</p>
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500">User Space</p>
        </div>
    </div>

    <nav class="mt-8 space-y-2">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['pattern']) 
                ? 'bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-blue-600 dark:text-cyan-400 font-semibold border-l-4 border-blue-500 dark:border-cyan-400' 
                : 'text-slate-500 dark:text-slate-400 hover:bg-gradient-to-r hover:from-slate-100 hover:to-slate-50 dark:hover:from-slate-800 dark:hover:to-slate-700/50 text-slate-600 dark:hover:text-white' }} flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium transition">
                <span class="material-symbols-outlined {{ request()->routeIs($link['pattern']) ? 'text-blue-500 dark:text-cyan-400' : '' }}">{{ $link['icon'] }}</span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
