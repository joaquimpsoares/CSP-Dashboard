@php
$additionalLink = null;
@endphp

@if (isset($filters))
@php

$name = isset($filters['name']) ? $filters['name'] : null;
$vendor = isset($filters['vendor']) ? $filters['vendor'] : null;
$quantity = isset($filters['quantity']) ? $filters['quantity'] : 12;

$additionalLink = "&search=1&name=" . $name . "&vendor=" . $vendor . "&quantity=" . $quantity;

@endphp
@endif

@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="disabled page-link"><span>&laquo;</span></li>
        @else
        <a href="?page=1{{ $additionalLink }}"  class="page-item"><li class="page-link">{{ ucwords(__('messages.first_page')) }}</li></a>
        <a href="{{ $paginator->previousPageUrl() }}{{ $additionalLink }}" rel="prev" class="page-item"><li class="page-link">&laquo;</li></a>
        @endif

        @if($paginator->currentPage() > 3)
        <a href="{{ $paginator->url(1) }}{{ $additionalLink }}" class="page-item"><li class="hidden-xs page-link">1</li></a>
        @endif
        @if($paginator->currentPage() > 4)
        <li class="disabled hidden-xs page-link"><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
        @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
        @if ($i == $paginator->currentPage())
        <a href="?page={{ $paginator->currentPage() }}{{ $additionalLink }}" class="page-item active">
            <li class=" page-link">
                <span>
                    @if ($paginator->currentPage() === $i)
                    <strong>
                        @endif
                        {{ $i }}
                        @if ($paginator->currentPage() === $i)
                    </strong>
                    @endif
                </span>
            </li>
        </a>
        @else
        <a href="{{ $paginator->url($i) }}{{ $additionalLink }}" class="page-item">
            <li class="page-link">
                {{ $i }}
            </li>
        </a>
        @endif
        @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="disabled hidden-xs page-link"><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <a href="{{ $paginator->url($paginator->lastPage()) }}{{ $additionalLink }}" class="page-item"><li class="hidden-xs page-link">{{ $paginator->lastPage() }}</li></a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}{{ $additionalLink }}" rel="next" class="page-item"><li class="page-link">&raquo;</li></a>
        <a href="?page={{$paginator->lastPage()}}{{ $additionalLink }}"  class="page-item"><li class="page-link right">{{ ucwords(__('messages.last_page')) }}</li></a>
        @else
        <li class="disabled page-link"><span>&raquo;</span></li>

        @endif
    </ul>
</nav>
@endif