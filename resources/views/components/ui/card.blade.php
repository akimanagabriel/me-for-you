@props([
    'title' => null,
    'compact' => false,
    'bordered' => false,
    'imageFull' => false,
])

<div {{ $attributes->merge(['class' => 'card bg-base-100 shadow-sm ' . ($bordered ? 'card-bordered ' : '') . ($compact ? 'card-compact ' : '') . ($imageFull ? 'image-full ' : '')]) }}>
    @isset($image)
        <figure>{{ $image }}</figure>
    @endisset

    @if ($title || isset($header))
        <div class="card-body">
            @isset($header)
                {{ $header }}
            @else
                <h2 class="card-title font-display text-2xl">{{ $title }}</h2>
            @endisset

            {{ $slot }}

            @isset($actions)
                <div class="card-actions justify-end mt-4">{{ $actions }}</div>
            @endisset
        </div>
    @else
        <div class="card-body">{{ $slot }}</div>
    @endif
</div>
