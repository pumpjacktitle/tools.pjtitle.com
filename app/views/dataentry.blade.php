@extends('layouts/default-fluid')

@section('styles')
@parent

{{ HTML::style('css/table.minified.css') }}
@stop

@section('scripts')
@parent
{{ HTML::script('js/table.minified.js') }}

<script type="text/javascript">
    $(function() {

        var ht;

        var maxed = false
            , resizeTimeout
            , availableWidth
            , availableHeight
            , $window = $(window)
            , $example1 = $('#example1');

        var calculateSize = function () {
            if(maxed) {
                var offset = $example1.offset();
                availableWidth = $window.width() - offset.left + $window.scrollLeft();
                availableHeight = $window.height() - offset.top + $window.scrollTop();
                $example1.width(availableWidth).height(availableHeight);
            }
        };

        var data = [
            [, '', , , 'COUNTRY TRAILS SUBDIVISION UNIT 7', 4, ''],
            [507, 'NAVARRO, N', 326, 32, 'Live Bee Land Subdivision No 4', 116, 14]
        ];

        $('#example1').handsontable({
            data: data,
            colHeaders: ["Abstract #", "Survey Name", "Survey #", "Ac", "Subdivision", "Block", "Lot"],
            minSpareRows: 1,
            colWidths: [80, 250, 70, 40, 300, 60, 60],
            contextMenu: true,
            manualColumnMove: true,
            manualColumnResize: true
        });

        $('#example1 table').addClass('table');

        $('.options input').on('change', function () {
            var method = this.checked ? 'addClass' : 'removeClass';
            $('#example1').find('table')[method](this.getAttribute('data-type'));
        });

        var childWindow;

        $("#loader").on('click', function() {
            openChildWindow();
        });

        $("#closer").on('click', function() {
            closeChildWindow();
        });

        $("#google").on('click', function() {
            refreshChildWindow();
        });

        function openChildWindow() {
            if (childWindow) {
                alert("We already have one open.");
            }
            else {
                childWindow = window.open('preview-window', '_blank', 'location=yes,toolbar=no');
            }
        }

        function closeChildWindow() {
            if (!childWindow) {
                alert("There is no child window open.");
            }
            else {
                childWindow.close();
                childWindow = undefined;
            }
        }

        function refreshChildWindow() {
            if ( ! childWindow) {
                alert("There is no child window open.");
            }
            else {
                childWindow.location = 'http://google.com';
            }
        }
    });
</script>
@stop

@section('content')

<div class="well">
    <p>
        This is a really quick demo of two features that Kristin has talked about both of these
        on several occasions.
    </p>

    <p>
        The table acts like excel, drag columns, use arrow keys to change rows, can copy multiple rows, etc.. Validation
        and autocomplete should still be available as well as auto-formatting of cells.
    </p>

    <p>
        The preview with the ability to be opened in a seperate window that would allow dual monitor use.  Ideally, when
        the previewer is opened, that original preview div would hide, the data entry form would expand to 100% coverage
        giving plenty of room. If the previewer was closed by a button in the child window, the preview div would display
        again in the normal spot and the data entry form would collapse back to normal size. <em>Those features are not in here, it's just a demo and didn't have time to fully dev it out.</em>
    </p>
</div>

<div class="row">
    <div class="col-sm-6" id="grid">
        <div id="example1"></div>
    </div>

    <div class="col-sm-6" id="previewer">

        <button id="loader" class="btn btn-default btn-xs">Open in New Window</button>
        <button id="closer" class="btn btn-default btn-xs">Close Window</button>
        <p></p>
        <embed src="/images/00107201.PDF" width="100%" height="700">
    </div>
</div>

@stop