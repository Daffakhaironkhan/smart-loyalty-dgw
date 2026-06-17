@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full rounded-xl bg-blue-50 px-4 py-2.5 text-start text-sm font-semibold text-blue-700 transition focus:outline-none focus:bg-blue-100'
        : 'block w-full rounded-xl px-4 py-2.5 text-start text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-blue-700 focus:outline-none focus:bg-slate-50 focus:text-blue-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
