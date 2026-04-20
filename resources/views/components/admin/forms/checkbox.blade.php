@props([
    'name',
    'label' => null,
    'value' => 1,
    'checked' => false,
    'disabled' => false,
    'help' => null,
    'wrapperClass' => '',
])

@php
    $id = $name . '_' . uniqid();
    $checked = old($name, $checked);
@endphp

<div class="{{ $wrapperClass }} mb-4">
    <div class="flex items-center">
        <input 
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            {{ $attributes }}
        />
        
        @if($label)
            <label for="{{ $id }}" class="ml-2 block text-sm text-gray-700">
                {{ $label }}
            </label>
        @endif
    </div>
    
    @if($help && !$errors->has($name))
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

