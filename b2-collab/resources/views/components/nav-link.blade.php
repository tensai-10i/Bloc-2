@props(['active'])

@php
$classes = ($active ?? false) ? 'navbar-link is-active' : 'navbar-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
