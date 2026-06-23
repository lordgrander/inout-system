
{{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <button class="disabled btn btn-outline-dark" aria-disabled="true"><span>&laquo;</span></button>
    @else
        <a style="color:black;" href="{{ $paginator->previousPageUrl() }}" rel="prev"><button class="btn btn-outline-dark">&laquo;</button></a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <button class="disabled btn btn-outline-dark" aria-disabled="true"><span>{{ $element }}</span></button>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <button class="active btn btn-outline-dark" aria-current="page"><span>{{ $page }}</span></button>
                @else
                <a style="color:black;" href="{{ $url }}"><button class="btn btn-outline-dark">{{ $page }}</button></a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a style="color:black;" href="{{ $paginator->nextPageUrl() }}" rel="next"><button class="btn btn-outline-dark">&raquo;</button></a>
    @else
        <button class="disabled btn btn-outline-dark" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span aria-hidden="true">&raquo;</span>
        </button>
    @endif
 