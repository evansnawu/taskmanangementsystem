@props(['options' => [],'name'=>'','value'=>''])

<select {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full']) }} name="{{ $name }}">
    @foreach ($options as $key => $value)
        <option value="{{ $key }}" {{ in_array($key, old($name) ?? ($selected ?? []), true) ? 'selected' : '' }}>
            {{ $value }}
        </option>
    @endforeach
</select>
