@forelse($statuses as $status)
    @include('statuses.partials.status')
@empty
    <p>This user hasn't posted a status yet.</p>
@endforelse

@if(count($statuses))
    <div class="centered">
        {{ $statuses->links() }}
    </div>
@endif