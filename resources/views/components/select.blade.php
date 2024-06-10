



@props(['selected' => null])

<select    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full']) }}>
    <option value="Pending" @if($selected === 'Pending') selected @endif>Pending</option>
    <option value="In Progress" @if($selected === 'In Progress') selected @endif>In Progress</option>
    <option value="Completed" @if($selected === 'Completed') selected @endif>Completed</option>
</select>
