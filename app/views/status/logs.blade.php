@extends('layouts/default')

@section('pageTitle')
Status Update Utility Logs
@stop

@section('scripts')
<script type="text/javascript">
    $(function() {
        var array = logs.reverse();
        var newHTML = [];
        for (var i = 0; i < array.length; i++) {
            newHTML.push('<li>' + array[i] + '</li>');
        }

        $("#log-display").html(newHTML.join(""));

        var reload = function ReloadPage() {
            location.reload();
        }

        setTimeout(reload, 300000);

    });
</script>
@stop

@section('content')

<h1>Migration Status Update Utility</h1>

<div class="well">
    <p>
        Below are the utility logs. These provide basic batch size and time completed statistics.
    </p>
</div>

<p class="alert alert-info">
    This page will automatically refresh every 5 minutes to display any new logs.
</p>

<div class="row">
    <div class="col-md-12" style="max-height: 400px; overflow-y: auto">
        <ul id="log-display">
        </ul>
    </div>
</div>
@stop