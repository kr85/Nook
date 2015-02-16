@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('statuses.partials.publish-status-form')

            <div class="scroller">
                @include('statuses.partials.statuses')
            </div>

        </div>
    </div>
@stop

@section('page-scripts')
    <script type="text/javascript">
        $(function() {
            $('ul.pagination:visible:first').hide();

            $('.scroller').jscroll({
                loadingHtml: '',
                debug: true,
                autoTrigger: true,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scroller',
                callback: function() {
                    $('ul.pagination:visible:first').hide();
                }
            });
        });
    </script>
@stop