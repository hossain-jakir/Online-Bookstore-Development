
<div class="col-md-6">
    <p class="page-text">Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</p>
</div>
<div class="col-md-6">
    <nav aria-label="Pagination">
        @if ($paginator->hasPages())
            <ul class="pagination style-1 p-t20">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link prev" aria-hidden="true">Prev</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link" style="color: #ffffff;background-color: #1a1668;border-color: #1a1668;">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link next" aria-hidden="true">Next</span>
                    </li>
                @endif
            </ul>
        @else
            <ul class="pagination style-1 p-t20">
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link prev" aria-hidden="true">Prev</span>
                </li>
                <li class="page-item disabled" aria-disabled="true"><span class="page-link" style="color: #ffffff;background-color: #1a1668;border-color: #1a1668;">1</span></li>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link next" aria-hidden="true">Next</span>
                </li>
            </ul>
        @endif
    </nav>
</div>

