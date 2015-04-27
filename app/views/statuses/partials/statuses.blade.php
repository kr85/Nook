@forelse($statuses as $status)
    @include('statuses.partials.status')
@empty
    <div class="col-md-6_5 timeline-status-form-offset no-status-fix">
        @if($signedIn)
            <p>You haven't posted a status yet.</p>
        @else
            <p>This user hasn't posted a status yet.</p>
        @endif
    </div>
@endforelse