@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm', 'style' => 'color: #3E3830;']) }}>
    {{ $value ?? $slot }}
</label>
