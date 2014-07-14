@extends('layouts/default')

@section('scripts')
<script type="text/javascript">
    $(function() {

       $("#button-execute").on('click', function() {

           // open our modal
           $('#processing-modal').modal({
               backdrop: 'static',
               keyboard: false,
               show: true
           });

           $('#button-execute').addClass('hide');

           // Assign handlers immediately after making the request,
           // and remember the jqXHR object for this request
           var jqxhr = $.ajax("{{ URL::to('tools/status-update-utility/execute') }}")
               .done(function( msg ) {
                   $('#button-execute').removeClass('hide');
               })
               .fail(function(msg) {
                   $('#button-execute').hide();
                   $("#status-notification").removeClass('hide');
               })
               .always(function() {
                   $('#processing-modal').modal('hide');
               });
       });

    });
</script>
@stop

@section('content')

<h1>Migration Status Update Utility</h1>

<div class="well">
    <p>
        Use the tool below to verify the migration status of legacy data in the old virtual courthouse. We will be checking
        to see:
    </p>

    <ul>
        <li>If and when the prime (instrument) was migrated.</li>
        <li>If the prime's prior references have been migrated</li>
        <li>If there are any duplicates</li>
    </ul>

    <p>
        The utility will run in batches of 100. To get started, click the button below. While the utility is running,
        please leave your web browser open.  You will be notified once the utility has completed.
    </p>
</div>

<p></p>

<div class="row">
    <div class="col-md-12">
        <button id="button-execute" class="btn btn-primary btn-lg" type="button">Run Utility</button>

        <div id="status-notification" class="alert alert-success hide">
            Yay, there are no more to be migrated. That was exciting :)
        </div>
    </div>
</div>

<div class="modal fade" id="processing-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="text-center">Processing...</h1>

                <p class="text-center">
                    We're processing the current batch. Once we've finished, this window will close.
                </p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop