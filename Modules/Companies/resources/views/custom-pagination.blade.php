@if ($paginator->hasPages())
    <div class="pagination-wrap hstack gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="page-item pagination-prev disabled" href="#">
                {{ __('companies.previous') }}
            </a>
        @else
            <a class="page-item pagination-prev" href="{{ $paginator->previousPageUrl() }}">
                {{ __('companies.previous') }}
            </a>
        @endif

        {{-- Pagination Elements --}}
        <ul class="pagination listjs-pagination mb-0">
            {{-- First Page --}}
            @if ($paginator->currentPage() > 3)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                @if ($paginator->currentPage() > 4)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- Previous Pages --}}
            @for ($i = max(1, $paginator->currentPage() - 2); $i < $paginator->currentPage(); $i++)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Current Page --}}
            <li class="page-item active">
                <span class="page-link">{{ $paginator->currentPage() }}</span>
            </li>

            {{-- Next Pages --}}
            @for ($i = $paginator->currentPage() + 1; $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Last Page --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="page-item pagination-next" href="{{ $paginator->nextPageUrl() }}">
                {{ __('companies.next') }}
            </a>
        @else
            <a class="page-item pagination-next disabled" href="#">
                {{ __('companies.next') }}
            </a>
        @endif
    </div>
@endif