@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-base font-medium leading-6 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-base font-medium leading-6 text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-900 focus:border-gray-300 transition duration-150 ease-in-out';
$activeStyle = ($active ?? false) ? 'border-color: #C09970;' : '';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $activeStyle]) }}>
    {{ $slot }}
</a>
