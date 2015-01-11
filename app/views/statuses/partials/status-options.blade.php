<ul class="dropdown-menu" role="menu">

    @if($status->user_id == $currentUser->id)
        <li>
            {{Form::open(['method' => 'DELETE', 'route' => ['delete_status_route', $status->id]])}}

            {{ Form::hidden('statusIdToDelete', $status->id) }}

                <input class="link-button" type="submit" value="Delete Status"/>

            {{ Form::close() }}
        </li>
        <li>
            {{Form::open(['method' => 'PATCH', 'route' => ['update_status_route', $status->id]])}}

                {{ Form::hidden('statusIdToUpdate', $status->id) }}

                <input class="link-button" type="submit" value="Edit Status"/>

            {{ Form::close() }}
        </li>
    @else
        <li>
            <p>Hide Status</p>
        </li>
    @endif
</ul>
