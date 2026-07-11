@props([
    'label' => null,
    'name' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
    'placeholder' => 'Select an option',
])

@php
    $selectId = $attributes->get('id', $name);
    $hasError = $error || ($name && $errors->has($name));
@endphp

<div class="form-control w-full">
    @if ($label)
        <label class="label" for="{{ $selectId }}">
            <span class="label-text font-medium">{{ $label }}@if($required)<span class="text-error">*</span>@endif</span>
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $selectId }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'select select-bordered w-full ' . ($hasError ? 'select-error' : '')]) }}
    >
        @if ($placeholder)
            <option disabled @selected(!old($name)) value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

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
