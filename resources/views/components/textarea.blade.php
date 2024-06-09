@props(['disabled' => false,'name'=>'','value'=>''])

<textarea {{ $attributes->merge(['class' => 'border border-gray-300 rounded-md w-full']) }} rows="{{ $rows ?? 3 }}"
    name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}>{{ old($name) ?? ($value ?? '') }}</textarea>
