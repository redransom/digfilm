@if ($paginator->lastPage() > 1)
<h2 class="pagination"><span>
    <span class="pagination-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url(1) }}"><<</a>
    </span>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <span class="pagination-item{{ ($paginator->currentPage() == $i) ? ' current' : '' }}">
            <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </span>
    @endfor
    <span class="pagination-item{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >>></a>
    </span>
    </span>
</h2>
@endif