@props([
    'variant' => 'neutral',
    'size' => 'md',
    'outline' => false,
])
@php
    $variants = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'accent' => 'badge-accent',
        'neutral' => 'badge-neutral',
        'info' => 'badge-info',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'error' => 'badge-error',
        'ghost' => 'badge-ghost',
    ];

    $sizes = [
        'xs' => 'badge-xs',
        'sm' => 'badge-sm',
        'md' => '',
        'lg' => 'badge-lg',
    ];

    $classes = 'badge ' . ($variants[$variant] ?? 'badge-neutral') . ' ' . ($sizes[$size] ?? '');
    if ($outline)
        $classes .= ' badge-outline';
@endphp
<span {{ $attributes->merge(['class' => $classes]) }}>
    <span class="px-2">{{ $slot }}</span>
</span>
