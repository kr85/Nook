@if ($paginator->getLastPage() > 1)
    <ul class="pagination">
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