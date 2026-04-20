<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'AssetFlow')) - {{ config('app.name', 'AssetFlow') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            900: '#172554',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        shell: '0 20px 45px -25px rgba(15, 23, 42, 0.25)',
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@300..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
            line-height: 1;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-slate-100 font-sans text-slate-900 antialiased">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    @php
        $user = auth()->user();
        $sidebarView = $user?->roleSidebarView() ?? 'includes.sidebar-utilisateur';
    @endphp

    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.10),_transparent_30%),linear-gradient(180deg,_#f8fafc_0%,_#eef2ff_100%)] dark:bg-[linear-gradient(180deg,_#020617_0%,_#0f172a_100%)]">
        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 backdrop-blur-sm lg:hidden"></div>

        <aside id="app-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full overflow-y-auto border-r border-slate-200/70 bg-white/95 shadow-shell backdrop-blur transition-transform duration-300 dark:border-slate-800 dark:bg-slate-950/95 lg:translate-x-0">
            @include($sidebarView)
        </aside>

        <div class="lg:pl-64">
            @include('includes.navbar')

            <main class="px-4 pb-8 pt-24 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/50 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:border-rose-900/60 dark:bg-rose-950/50 dark:text-rose-300">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const html = document.documentElement;
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        function toggleSidebar() {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }

        function toggleTheme() {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        }

        overlay?.addEventListener('click', closeSidebar);

        document.addEventListener('click', function (event) {
            document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
                const trigger = document.querySelector(`[data-dropdown-trigger="${dropdown.dataset.dropdown}"]`);

                if (!dropdown.contains(event.target) && !trigger?.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        function toggleDropdown(name) {
            const dropdown = document.querySelector(`[data-dropdown="${name}"]`);
            dropdown?.classList.toggle('hidden');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function (event) {
            const button = event.target.closest('.delete-confirm');

            if (!button) {
                return;
            }

            event.preventDefault();

            Swal.fire({
                title: 'Delete this item?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#e11d48',
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form')?.submit();
                }
            });
        });

        $(function () {
            $('.select2').select2({ width: '100%' });
        });
    </script>
    @stack('scripts')
</body>
</html>
