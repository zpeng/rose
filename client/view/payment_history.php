<h1 class="content_title">Payment History</h1>
<div id="notification"></div>
<div id="content">
    <table style="width: 900px;" border="0">
        <tr>
            <td style="width: 450px; text-align: left"><b>Start Date: </b><input name="start_date" id="start_date" style="width: 120px;"/></td>
            <td style="width: 450px; text-align: left"><b>End Date:</b> <input name="end_date" id="end_date" style="width: 120px;"/></td>
        </tr>
    </table>
    <div id="payment_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
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

        var payment_grid;
        var columns = [
            {id: "id", name: "ID", field: "id", width: 60},
            {id: "timestamp", name: "Payment Time", field: "timestamp", width: 120},
            {id: "amount", name: "Amount", field: "amount", width: 80},
            {id: "payment_method", name: "Payment Method", field: "payment_method", width: 120},
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
                    operation_id: "fetch_payment_table",
                    client_id: <?=$client_id?>,
                    start: $("#start_date").val(),
                    end: $("#end_date").val()
                },
                dataType: "json",
                success: function (data) {
                    payment_grid = new Slick.Grid("#payment_grid", data, columns, options);
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
    });
</script>