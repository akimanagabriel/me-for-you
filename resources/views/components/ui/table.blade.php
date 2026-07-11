@props([
    'zebra' => true,
    'compact' => false,
    'hover' => true,
    'pinRows' => false,
    'pinCols' => false,
    'empty' => 'No records found.',
    'emptyIcon' => true,
])

<div class="overflow-x-auto rounded-box border border-base-300">
    <table {{ $attributes->merge(['class' => 'table ' . ($zebra ? 'table-zebra ' : '') . ($compact ? 'table-sm ' : '') . ($hover ? 'table-hover ' : '') . ($pinRows ? 'table-pin-rows ' : '') . ($pinCols ? 'table-pin-cols ' : '')]) }}>
        @isset($head)
            <thead class="bg-base-200">
                <tr>{{ $head }}</tr>
            </thead>
        @endisset

        <tbody>
            @if (trim($slot))
                {{ $slot }}
            @else
                <tr>
                    <td colspan="100" class="text-center py-12">
                        <div class="flex flex-col items-center gap-3 text-base-content/50">
                            @if ($emptyIcon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            @endif
                            <p class="text-sm">{{ $empty }}</p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
