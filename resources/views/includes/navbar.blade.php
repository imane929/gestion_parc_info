@php
    $user = auth()->user();
    $unreadNotifications = $user?->notifications()->whereNull('lu_at')->latest()->limit(5)->get() ?? collect();
    $unreadCount = $unreadNotifications->count();
@endphp

<header class="fixed inset-x-0 top-0 z-20 border-b border-white/60 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-950/80 lg:left-64">
    <div class="flex h-20 items-center gap-3 px-4 sm:px-6 lg:px-8">
        <button type="button" onclick="toggleSidebar()" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 lg:hidden">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <form action="{{ route('admin.search') }}" method="GET" class="flex-1">
            <label class="flex h-11 items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 shadow-sm transition focus-within:border-brand-500 focus-within:bg-white dark:border-slate-800 dark:bg-slate-900 dark:focus-within:border-brand-500">
                <span class="material-symbols-outlined text-slate-400">search</span>
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search assets, tickets, users, software..."
                    class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 outline-none ring-0 placeholder:text-slate-400 focus:ring-0 dark:text-slate-200"
                >
            </label>
        </form>

        <div class="flex items-center gap-2">
            <button type="button" onclick="toggleTheme()" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                <span class="material-symbols-outlined">contrast</span>
            </button>

            <div class="relative">
                <button type="button" data-dropdown-trigger="notifications" onclick="toggleDropdown('notifications')" class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                    <span class="material-symbols-outlined">notifications</span>
                    @if ($unreadCount > 0)
                        <span class="absolute right-2 top-2 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>

                <div data-dropdown="notifications" class="absolute right-0 mt-3 hidden w-80 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-shell dark:border-slate-800 dark:bg-slate-950">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Notifications</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $unreadCount }} unread</p>
                        </div>
                        <a href="{{ route('admin.notifications.index') }}" class="text-xs font-semibold text-brand-600">Voir tout</a>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        @forelse ($unreadNotifications as $notification)
                            <a href="{{ route('admin.notifications.index') }}" class="block border-b border-slate-100 px-5 py-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $notification->titre }}</p>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($notification->message, 100) }}</p>
                                <p class="mt-2 text-[11px] font-medium text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <div class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                No new notifications.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="relative">
                <button type="button" data-dropdown-trigger="profile" onclick="toggleDropdown('profile')" class="flex h-11 items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    @if($user?->photo_url)
                        <img src="{{ $user->photo_url }}" alt="{{ $user->full_name }}" class="h-9 w-9 rounded-2xl object-cover">
                    @else
                        <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">
                            {{ $user?->initials }}
                        </div>
                    @endif
                    <div class="hidden text-left sm:block">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user?->full_name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user?->roleDisplayName() }}</p>
                    </div>
                    <span class="material-symbols-outlined hidden text-slate-400 sm:block">expand_more</span>
                </button>

                <div data-dropdown="profile" class="absolute right-0 mt-3 hidden w-64 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-shell dark:border-slate-800 dark:bg-slate-950">
                    <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user?->full_name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user?->email }}</p>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('admin.profile.show') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white">
                            <span class="material-symbols-outlined">person</span>
                            Profil
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white">
                            <span class="material-symbols-outlined">settings</span>
                            Paramètres du compte
                        </a>
                    </div>
                    <div class="border-t border-slate-100 p-2 dark:border-slate-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 dark:hover:bg-rose-950/50">
                                <span class="material-symbols-outlined">logout</span>
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
