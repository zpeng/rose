<h1 class="content_title">Call History</h1>
<div id="notification"></div>
<div id="content">
    <table style="width: 900px;" border="0">
        <tr>
            <td style="width: 300px; text-align: left"><b>Start Date: </b><input name="start_date" id="start_date" style="width: 120px;"/></td>
            <td style="width: 300px; text-align: left"><b>End Date:</b> <input name="end_date" id="end_date" style="width: 120px;"/></td>
            <td style="width: 300px; text-align: right"><input type="button" id="print_button" name="print_button" class="print_button" /></td>
        </tr>
    </table>
    <div id="call_log_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>
<script>
    // load css
    head.js(<?=outputDependencies(
    array(
    "jquery-ui-css",
    "slickgrid-css")
    , $CSS_DEPS)?>);

    // load js
    head.js(<?=outputDependencies(
    array(
    "slickgrid",
    "jquery-ui")
    , $JS_DEPS)?>, function () {

        //date picker
        $("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#start_date").datepicker('setDate', '-1m');
        $("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#end_date").datepicker('setDate', '+1d');

        var call_log_grid;
        var columns = [
            {id: "call_number", name: "Calling At", field: "call_number", width: 200},
            {id: "timestamp", name: "Start At", field: "timestamp", width: 200},
            {id: "duration", name: "Duration", field: "duration", width: 150},
            {id: "charge", name: "Charge", field: "charge", width: 100}
        ];
        var options = {
            enableCellNavigation: true,
            enableColumnReorder: false,
            forceFitColumns: true,
            enableTextSelectionOnCells: true
        };

        //use ajax to load data source
        function fetch_data() {
            $.ajax({
                url: SERVER_URL + "client/control/fetch_service.php",
                type: "POST",
                data: {
                    operation_id: "fetch_call_log_table",
                    client_id: <?=$client_id?>,
                    start: $("#start_date").val(),
                    end: $("#end_date").val()
                },
                dataType: "json",
                success: function (data) {
                    call_log_grid = new Slick.Grid("#call_log_grid", data, columns, options);
                },
                error: function (msg) {
                    ajaxFailMsg(msg);
                }
            });
        }

        //when page rendering is completed
        $(document).ready(function () {
            fetch_data();
        });

        $("#start_date").change(function () {
            fetch_data();
        });

        $("#end_date").change(function () {
            fetch_data();
        });



        $( "#print_button" ).click(function() {
            var url = SERVER_URL + "client/control/call_log_print.php";
            url = url + "?start=" + $("#start_date").val();
            url = url + "&end=" + $("#end_date").val();
            //alert(url);
            window.open(url, '_blank');
        });
    });
</script>