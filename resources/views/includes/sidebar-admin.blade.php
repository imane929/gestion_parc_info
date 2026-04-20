@php
    $item = fn (string $routePattern, string $icon, string $label, string $url) => [
        'active' => request()->routeIs($routePattern),
        'icon' => $icon,
        'label' => $label,
        'url' => $url,
    ];

    $menu = [
        'Overview' => [
            $item('admin.dashboard.admin', 'dashboard', 'Dashboard', route('admin.dashboard.admin')),
            $item('admin.dashboard.analytics', 'monitoring', 'Analytics', route('admin.dashboard.analytics')),
        ],
        'Operations' => [
            $item('admin.actifs.*', 'inventory_2', 'Assets', route('admin.actifs.index')),
            $item('admin.assignments', 'assignment_ind', 'Assignments', route('admin.assignments')),
            $item('admin.maintenances.*', 'build', 'Maintenance', route('admin.maintenances.index')),
            $item('admin.software-licenses', 'license', 'Software & Licenses', route('admin.software-licenses')),
            $item('admin.localisations.*', 'location_on', 'Locations', route('admin.localisations.index')),
            $item('admin.reports.*', 'bar_chart', 'Reports', route('admin.reports.index')),
        ],
        'Administration' => [
            $item('admin.utilisateurs.*', 'group', 'Users', route('admin.utilisateurs.index')),
            $item('admin.settings.*', 'settings', 'Settings', route('admin.settings.index')),
        ],
    ];
@endphp

<div class="flex h-full flex-col px-4 py-6">
    <div class="flex items-center gap-3 px-2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 via-brand-600 to-slate-900 text-white shadow-lg">
            <span class="material-symbols-outlined">developer_board</span>
        </div>
        <div>
            <p class="text-lg font-black tracking-tight text-slate-900 dark:text-white">AssetFlow</p>
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-slate-400">Admin Portal</p>
        </div>
    </div>

    <div class="mt-8 overflow-y-auto pr-1">
        @foreach ($menu as $section => $links)
            <div class="mb-6">
                <p class="px-3 text-[11px] font-bold uppercase tracking-[0.3em] text-slate-400">{{ $section }}</p>
                <div class="mt-3 space-y-1">
                    @foreach ($links as $link)
                        <a href="{{ $link['url'] }}" class="{{ $link['active'] ? 'bg-brand-50 text-brand-700 dark:bg-brand-950/70 dark:text-brand-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900' }} flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold transition">
                            <span class="material-symbols-outlined">{{ $link['icon'] }}</span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
