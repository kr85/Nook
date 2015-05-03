<div class="status-likes-options">
    <div class="status-options-box">
        @include('statuses.partials.status-like', ['status' => $status])
        <div class="likes-owners-box">
            <span>
                {{ $status->present()->displayLikesOwners() }}
            </span>
        </div>
        <a href="" class="dropdown-toggle status-more-options" aria-hidden="true" data-toggle="dropdown"></a>
        @include('statuses.partials.status-options', ['status' => $status])
    </div>
</div>