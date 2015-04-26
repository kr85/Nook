@if ($paginator->getLastPage() > 1)
    <ul class="pagination" id="pagination-{{ $paginator->getCurrentPage() }}">
        <li>
            <a
                href="{{ $paginator->getUrl($paginator->getCurrentPage() + 1) }}"
                class="{{ ($paginator->getCurrentPage() == $paginator->getLastPage()) ? ' disabled' : 'active' }} load-more"
            >
                Load more
            </a>
        </li>
    </ul>
@endif