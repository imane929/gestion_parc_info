<div class="stat-card {{ $color ?? 'blue' }}">
    <div class="stat-icon {{ $color ?? 'blue' }}">
        <i class="{{ $icon ?? 'fas fa-chart-bar' }}"></i>
    </div>
    <div class="stat-info">
        <h3>{{ $value ?? 0 }}</h3>
        <p>{{ $label ?? 'Label' }}</p>
    </div>
</div>
