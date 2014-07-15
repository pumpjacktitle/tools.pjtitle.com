@extends('layouts/default-fluid')

@section('styles')
@parent

{{ HTML::style('css/handsOnTable.full.css') }}
{{ HTML::style('css/handsOnTable.bootstrap.css') }}
@stop

@section('scripts')
@parent
{{ HTML::script('js/handsOnTable.full.js') }}

<script type="text/javascript">
    $(function() {

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

        var ip_validator_regexp = /^(?:\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b|null)$/;

        var data = [
            [, '', , , 'COUNTRY TRAILS SUBDIVISION UNIT 7', 4, ''],
            [507, 'NAVARRO, N', 326, 32, 'Live Bee Land Subdivision No 4', 116, 14]
        ];

        $('#example1').handsontable({
            data: data,
            colHeaders: ["Abstract #", "Survey Name", "Survey #", "Acreage", "Subdivision", "Block", "Lot"],
            minSpareRows: 1,
            colWidths: [100, 300, 85, 80, 300, 80, 80],
            contextMenu: true,
            manualColumnMove: true,
            manualColumnResize: true,
            persistentState: true
        });

        $('#example1 table').addClass('table');

        $('.options input').on('change', function () {
            var method = this.checked ? 'addClass' : 'removeClass';
            $('#example1').find('table')[method](this.getAttribute('data-type'));
        });
    });
</script>
@stop

@section('content')

<div id="example1"></div>

@stop