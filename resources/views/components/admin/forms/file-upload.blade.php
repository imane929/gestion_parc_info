@props([
    'name',
    'label' => null,
    'multiple' => false,
    'accept' => null,
    'required' => false,
    'disabled' => false,
    'help' => null,
    'preview' => false,
    'existingFiles' => [],
    'wrapperClass' => '',
])

@php
    $id = $name . '_' . uniqid();
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
    
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="{{ $id }}" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <span>Télécharger un fichier</span>
                    <input 
                        id="{{ $id }}"
                        name="{{ $multiple ? $name . '[]' : $name }}"
                        type="file"
                        @if($multiple) multiple @endif
                        @if($accept) accept="{{ $accept }}" @endif
                        @if($required) required @endif
                        @if($disabled) disabled @endif
                        class="sr-only"
                        {{ $attributes }}
                    />
                </label>
                <p class="pl-1">ou glisser-déposer</p>
            </div>
            <p class="text-xs text-gray-500">
                PNG, JPG, PDF jusqu'à 10MB
            </p>
        </div>
    </div>
    
    @if($preview && !empty($existingFiles))
        <div class="mt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Fichiers existants:</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($existingFiles as $file)
                    <div class="border rounded-lg p-2">
                        <div class="flex items-center">
                            @if(str_starts_with($file->mime, 'image/'))
                                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @elseif($file->mime === 'application/pdf')
                                <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                            <span class="text-sm truncate">{{ $file->nom_fichier }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($help && !$errors->has($name))
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

