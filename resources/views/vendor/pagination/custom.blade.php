@if ($paginator->hasPages())
    <div class="pagination-wrapper" style="display: flex; justify-content: center; width: 100%;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-nav" style="opacity: 0.5; cursor: not-allowed;">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-nav" rel="prev">
                &laquo; Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-btn" style="cursor: default;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-nav" rel="next">
                Next &raquo;
            </a>
        @else
            <span class="page-nav" style="opacity: 0.5; cursor: not-allowed;">
                Next &raquo;
            </span>
        @endif
    </div>
@endif
