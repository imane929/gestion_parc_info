@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'from-blue-500 to-blue-600 shadow-blue-500/20',
        'green' => 'from-emerald-500 to-green-600 shadow-emerald-500/20',
        'orange' => 'from-amber-500 to-orange-500 shadow-amber-500/20',
        'red' => 'from-rose-500 to-red-600 shadow-rose-500/20',
        'purple' => 'from-purple-500 to-indigo-600 shadow-purple-500/20',
    ];
    $gradient = $colors[$color] ?? $colors['blue'];
@endphp

<div class="group bg-gradient-to-br {{ $gradient }} rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
    <div class="flex items-center justify-between mb-3">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">{{ $icon }}</span>
        </div>
    </div>
    <div class="text-3xl font-bold mb-1">{{ $value }}</div>
    <div class="text-sm text-white/80 font-medium">{{ $title }}</div>
</div>
