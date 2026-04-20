@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Sélectionner...',
    'required' => false,
    'disabled' => false,
    'help' => null,
    'multiple' => false,
    'wrapperClass' => '',
])

@php
    $id = $name . '_' . uniqid();
    $value = old($name, $value);
    
    $classes = 'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm';
    
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
    
    <select 
        id="{{ $id }}"
        name="{{ $multiple ? $name . '[]' : $name }}"
        @if($multiple) multiple @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="{{ $classes }} select2"
        {{ $attributes }}
    >
        @if($placeholder && !$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $key => $option)
            @if(is_array($option))
                <optgroup label="{{ $key }}">
                    @foreach($option as $subKey => $subOption)
                        <option value="{{ $subKey }}" 
                            @if($multiple)
                                {{ is_array($value) && in_array($subKey, $value) ? 'selected' : '' }}
                            @else
                                {{ $value == $subKey ? 'selected' : '' }}
                            @endif
                        >
                            {{ $subOption }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $key }}" 
                    @if($multiple)
                        {{ is_array($value) && in_array($key, $value) ? 'selected' : '' }}
                    @else
                        {{ $value == $key ? 'selected' : '' }}
                    @endif
                >
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>
    
    @if($help && !$errors->has($name))
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

