@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-xl transition-all duration-300 group shadow-sm shadow-blue-500/5'
            : 'inline-flex items-center px-4 py-2 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-all duration-300 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
