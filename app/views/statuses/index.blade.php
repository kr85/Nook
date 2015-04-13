@extends('layouts.master')

@section('content')
    <div class="container navbar-padding">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                @include('statuses.partials.publish-status-form')

                <div class="scroller">
                    @include('statuses.partials.statuses')
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-scripts')
    <script type="text/javascript">
        $(function() {
            var i = 0, link;
            $('.scroller').jscroll({
                loadingHtml: '<div class="centered" style="margin-bottom: 25px; margin-top: -40px;"><img src="../images/pages/loading.gif" alt="Loading..." width="75" height="75"/></div>',
                debug: false,
                animate: true,
                autoTrigger: false,
                nextSelector: '.pagination li a.active',
                contentSelector: 'div.scroller',
                callback: function() {
                    i++;
                    link = '#pagination-' + i;
                    $(link).hide();
                }
            });
        });
    </script>
@stop