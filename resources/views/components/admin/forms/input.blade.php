@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
    'error' => null,
    'class' => '',
    'wrapperClass' => '',
])

@php
    $id = $name . '_' . uniqid();
    $value = old($name, $value);
    
    $classes = 'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm ' . $class;
    
    if ($errors->has($name)) {
        $classes .= ' border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500';
    }
    
    if ($disabled) {
        $classes .= ' bg-gray-100 cursor-not-allowed';
    }
@endphp

<div class="{{ $wrapperClass }} mb-4">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    @if($type === 'textarea')
        <textarea 
            id="{{ $id }}"
            name="{{ $name }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            class="{{ $classes }}"
            rows="3"
            {{ $attributes }}
        >{{ $value }}</textarea>
    @elseif($type === 'select')
        <select 
            id="{{ $id }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            class="{{ $classes }}"
            {{ $attributes }}
        >
            {{ $slot }}
        </select>
    @else
        <input 
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            class="{{ $classes }}"
            {{ $attributes }}
        />
    @endif
    
    @if($help && !$errors->has($name))
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

