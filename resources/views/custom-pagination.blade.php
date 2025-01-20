<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link"><i class="fa fa-backward"></i></span></li>
    @else
        <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="fa fa-backward"></i></a></li>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="fa fa-forward"></i></a></li>
    @else
        <li class="page-item disabled"><span class="page-link"><i class="fa fa-forward"></i></span></li>
    @endif
</ul>
