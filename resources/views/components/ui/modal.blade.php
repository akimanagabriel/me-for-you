@props([
    'id' => 'modal',
    'title' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];
@endphp

<dialog {{ $attributes->merge(['id' => $id, 'class' => 'modal']) }}>
    <div class="modal-box {{ $sizes[$size] ?? 'max-w-lg' }}">
        @if ($title)
            <h3 class="font-display text-2xl font-semibold mb-4">{{ $title }}</h3>
        @endif

        {{ $slot }}

        @isset($actions)
            <div class="modal-action">{{ $actions }}</div>
        @endisset
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
