@if ($paginator->hasPages())

    <nav aria-label="..." class="mb-5">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link">Anterior</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Anterior</a>
                </li>
            @endif

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <a></a>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item ">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Próximo</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link">Próximo</a>
                </li>
            @endif

        </ul>
    </nav>
    @endif
