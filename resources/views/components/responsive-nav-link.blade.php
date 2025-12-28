@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-6 py-4 bg-white text-blue-700 rounded-2xl border-l-4 border-blue-600 shadow-sm transition-all duration-300'
            : 'block w-full px-6 py-4 text-slate-500 hover:text-slate-900 hover:bg-white rounded-2xl border-l-4 border-transparent transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
