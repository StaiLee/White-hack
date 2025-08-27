@props(['active'])

@php
$classes = $active
    ? 'inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium text-slate-100 bg-slate-800 border border-slate-700'
    : 'inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium text-slate-300 hover:text-slate-100 hover:bg-slate-900/60 border border-transparent';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
