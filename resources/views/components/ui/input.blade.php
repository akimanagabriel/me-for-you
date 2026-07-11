@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'error' => null,
    'hint' => null,
    'required' => false,
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = $error || $errors->has($name);
@endphp

<div class="form-control w-full">
    @if ($label)
        <label class="label" for="{{ $inputId }}">
            <span class="label-text font-medium">{{ $label }}@if($required)<span class="text-error">*</span>@endif</span>
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'input input-bordered w-full ' . ($hasError ? 'input-error' : '')]) }}
    />

    @if ($hint && !$hasError)
        <label class="label">
            <span class="label-text-alt text-base-content/60">{{ $hint }}</span>
        </label>
    @endif

    @if ($hasError)
        <label class="label">
            <span class="label-text-alt text-error">{{ $error ?? $errors->first($name) }}</span>
        </label>
    @endif
</div>
