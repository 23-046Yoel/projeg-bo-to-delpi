@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-8 py-4 text-sm font-bold text-gray-900 bg-gold/5 border-r-4 border-gold group transition-all duration-300'
            : 'flex items-center w-full px-8 py-4 text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gold/5 border-r-4 border-transparent hover:border-gold/20 group transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
    