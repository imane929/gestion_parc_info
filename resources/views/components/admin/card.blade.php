<div class="card {{ $class ?? '' }}">
    <div class="card-header {{ isset($noPadding) && $noPadding ? 'p-0' : '' }}">
        <div class="d-flex justify-content-between align-items-center {{ isset($noPadding) && $noPadding ? 'p-3' : '' }}">
            <h6 class="mb-0">
                @if(isset($icon))
                    <i class="{{ $icon }} me-2 text-{{ $iconColor ?? 'primary' }}"></i>
                @endif
                {{ $title ?? 'Card Title' }}
            </h6>
            @if(isset($action))
                <a href="{{ $actionUrl ?? '#' }}" class="btn btn-sm btn-outline-primary">
                    {{ $action }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            @endif
        </div>
    </div>
    @if(isset($bodyClass))
        <div class="card-body {{ $bodyClass }}">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
