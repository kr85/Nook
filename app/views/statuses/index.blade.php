@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6_5 timeline-status-form-offset">
                <div class="timeline-wrapper navbar-padding">
                    @include('statuses.partials.publish-status-form')
                </div>
            </div>
        </div>
        <div class="row">
            <div id="timeline">
                @include('statuses.partials.statuses')
            </div>
            @if(count($statuses) >= 25)
                <div class="col-md-6_5 timeline-status-form-offset">
                    <div class="timeline-wrapper timeline-wrapper-last-child">
                        <div class="centered">
                            {{ $statuses->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6_5 timeline-status-form-offset loading-image" style="display: none;">
                    <div class="timeline-wrapper">
                        <div class="centered" style="margin-bottom: 25px; margin-top: -10px;">
                            <img src="../images/pages/loading.gif" alt="Loading..." width="75" height="75"/>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection