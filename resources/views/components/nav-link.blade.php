@props(['active', 'icon' => null])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-1 pt-1 text-sm font-semibold leading-5 text-indigo-600 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
: 'inline-flex items-center px-1 pt-1 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-blue-600 hover:border-gray-300 focus:outline-none focus:text-blue-600 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
    <i class="{{ $icon }} me-2"></i>
    @endif
    {{ $slot }}
</a>