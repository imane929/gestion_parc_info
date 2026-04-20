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
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
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
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
            line-height: 1;
            vertical-align: middle;
        }
        
        /* Base dark mode styles */
        .dark body {
            background-color: #020617;
            color: #f1f5f9;
        }
        
        /* Dark mode cards */
        .dark .bg-white {
            background-color: #0f172a !important;
        }
        
        .dark .bg-slate-50,
        .dark .bg-slate-50\/50 {
            background-color: #1e293b !important;
        }
        
        .dark .bg-slate-100 {
            background-color: #1e293b !important;
        }
        
        /* Dark mode borders */
        .dark .border-slate-200,
        .dark .border-slate-200\/60,
        .dark .border-slate-200\/70 {
            border-color: #334155 !important;
        }
        
        .dark .border-slate-100 {
            border-color: #1e293b !important;
        }
        
        /* Dark mode text */
        .dark .text-slate-900,
        .dark .text-slate-800,
        .dark .text-slate-700 {
            color: #f1f5f9 !important;
        }
        
        .dark .text-slate-600,
        .dark .text-slate-500,
        .dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        
        /* Dark mode inputs */
        .dark input,
        .dark textarea,
        .dark select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #64748b !important;
        }
        
        /* Dark mode tables */
        .dark .divide-slate-200 > :not([style*="background-color"]) > * {
            border-color: #334155 !important;
        }
        
        .dark tbody tr:hover {
            background-color: #1e293b !important;
        }
        
        /* Dark mode dropdowns (Select2) */
        .dark .select2-container--default .select2-selection--single,
        .dark .select2-container--default .select2-selection--multiple {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered,
        .dark .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: #f1f5f9 !important;
        }
        
        .dark .select2-container--default .select2-selection--single .select2-selection__arrow b,
        .dark .select2-dropdown,
        .dark .select2-results__option {
            border-color: #334155 !important;
        }
        
        .dark .select2-dropdown {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        
        .dark .select2-results__option--highlighted[aria-selected] {
            background-color: #334155 !important;
        }
        
        .dark .select2-search__field {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        /* Dark mode SweetAlert */
        .dark .swal2-popup {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        
        .dark .swal2-title,
        .dark .swal2-html-container {
            color: #f1f5f9 !important;
        }
        
        .dark .swal2-footer {
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }
        
        .dark .swal2-input,
        .dark .swal2-textarea {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        .dark .swal2-checkbox input {
            border-color: #334155 !important;
        }
        
        /* Dark mode modals */
        .dark .modal-content,
        .dark .modal-header,
        .dark .modal-body,
        .dark .modal-footer {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        /* Dark mode buttons */
        .dark .btn-primary,
        .dark .btn-secondary,
        .dark .btn-outline-secondary {
            background-color: #334155 !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        .dark .btn-primary:hover {
            background-color: #475569 !important;
        }
        
        /* Dark mode alerts */
        .dark .alert-success {
            background-color: #064e3b !important;
            border-color: #065f46 !important;
            color: #6ee7b7 !important;
        }
        
        .dark .alert-danger {
            background-color: #7f1d1d !important;
            border-color: #991b1b !important;
            color: #fca5a5 !important;
        }
        
        .dark .alert-warning {
            background-color: #78350f !important;
            border-color: #92400e !important;
            color: #fcd34d !important;
        }
        
        .dark .alert-info {
            background-color: #1e3a5f !important;
            border-color: #1e40af !important;
            color: #93c5fd !important;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-slate-100 font-sans text-slate-900 antialiased">
    <script>
        // Apply theme before render to prevent flash
        (function() {
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @php
        $user = auth()->user();
        $sidebarView = $user?->roleSidebarView() ?? 'includes.sidebar-utilisateur';
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 backdrop-blur-sm lg:hidden"></div>

        <aside id="app-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full overflow-y-auto border-r border-slate-200/70 bg-white shadow-shell backdrop-blur transition-transform duration-300 lg:translate-x-0 dark:border-slate-700 dark:bg-slate-900">
            @include($sidebarView)
        </aside>

        <div class="lg:pl-64">
            @include('includes.navbar')

            <main class="px-4 pb-8 pt-24 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:border-rose-800 dark:bg-rose-900/50 dark:text-rose-300">
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
            // Dispatch event for components that need to update
            window.dispatchEvent(new Event('theme-changed'));
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
        
        // Listen for theme changes and reinitialize components
        window.addEventListener('theme-changed', function() {
            // Reinitialize Select2 with dark mode
            $('.select2').select2({
                width: '100%',
                theme: html.classList.contains('dark') ? 'dark' : 'default'
            });
            
            // Update SweetAlert global options
            if (typeof Swal !== 'undefined') {
                Swal.setDefaults({
                    background: html.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    color: html.classList.contains('dark') ? '#f1f5f9' : '#1e293b'
                });
            }
        });
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

            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Delete this item?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#e11d48',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f1f5f9' : '#1e293b'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form')?.submit();
                }
            });
        });

        $(function () {
            // Initialize Select2 with current theme
            const isDark = document.documentElement.classList.contains('dark');
            $('.select2').select2({ 
                width: '100%',
                theme: isDark ? 'dark' : 'default'
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
