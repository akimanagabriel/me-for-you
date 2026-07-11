@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
        'link' => 'btn-link',
        'error' => 'btn-error',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'neutral' => 'btn-neutral',
    ];

    $sizes = [
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ];

    $classes = 'btn ' . ($variants[$variant] ?? 'btn-primary') . ' ' . ($sizes[$size] ?? '');
    if ($loading) $classes .= ' loading';
    if ($disabled) $classes .= ' btn-disabled';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <span class="loading loading-spinner loading-sm"></span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" @disabled($disabled || $loading) {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <span class="loading loading-spinner loading-sm"></span>
        @endif
        {{ $slot }}
    </button>
@endif
