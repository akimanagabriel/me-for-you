@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
        <p class="text-sm text-base-content/60">
            Showing {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}
        </p>

        <div class="join">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="join-item btn btn-sm btn-disabled">«</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm">«</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <button class="join-item btn btn-sm btn-disabled">{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="join-item btn btn-sm btn-primary">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="join-item btn btn-sm">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm">»</a>
            @else
                <button class="join-item btn btn-sm btn-disabled">»</button>
            @endif
        </div>
    </div>
@endif
