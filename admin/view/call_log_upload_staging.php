<h1 class="content_title">Call Log Upload</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\Client;

    $csv_file = $_REQUEST['csv_file'];

    $num_rows = 0;
    $array_from_csv = readCSV($csv_file);
    $dataSource = array();
    foreach ($array_from_csv as $data) {
        if ($data[0] != "") {
            ++$num_rows;

            array_push($dataSource, array(
                "client_id" => trim($data[0]),
                "timestamp" => trim($data[1]),
                "call_number" => trim($data[2]),
                "destination" => trim($data[3]),
                "duration" => str_replace(" ", "", $data[4]),
                "base_rate" => trim($data[5])
            ));
        }
    }

    ?>
    <div class="important_announce">
        <b>Make sure you check the following items before proceeding:
            <br> - Is the total number of records matching with you original excel sheet or csv file ?
            <br> - Is each data columns matching our data contract
            <br> - Is the data appears in the table correct? Is the data structure correct?
        </b>
    </div>


    <form id="csvLogCallInsertForm" method="post" action="<?= SERVER_URL ?>admin/control/call_log_insert.php">
        <input type="hidden" value="<? echo $csv_file ?>" name="csv_file" id="csv_file"/>
        <table width="900" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Location of the Call Log File: </b></td>
                <td><?=$csv_file?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b> Number of Records</b>: </b></td>
                <td><?=$num_rows?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="call_log_grid" class="slickgrid_table" style="width: 900px; height: 350px"></div>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <a id="abort_btn" href="<?= SERVER_URL ?>/admin/index.php?view=call_log_list">Abort</a>
                    <input name='Update' id="call_log_proceed_btn" type='submit' value='Proceed'/>
                </td>
            </tr>
        </table>
    </form>
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
    "jquery-ui"
    )
    , $JS_DEPS)?>, function () {
        $("#abort_btn").button();
        $("#call_log_proceed_btn").button();

        $('#csvLogCallInsertForm').submit(function() {
            return confirm("Please confirm you want to continue?");
        });

        //when page rendering is completed
        $(document).ready(function () {
            var call_log_grid;
            var columns = [
                {id: "client_id", name: "Client Id", field: "client_id", width: 150},
                {id: "timestamp", name: "Call Timestamp", field: "timestamp", width: 150},
                {id: "call_number", name: "Calling Number", field: "call_number", width: 150},
                {id: "destination", name: "Destination", field: "destination", width: 150},
                {id: "duration", name: "Duration", field: "duration", width: 150},
                {id: "base_rate", name: "Base Charge", field: "base_rate", width: 150}
            ];
            var options = {
                enableCellNavigation: true,
                enableColumnReorder: false,
                forceFitColumns: true,
                enableTextSelectionOnCells: true
            };
            call_log_grid = new Slick.Grid("#call_log_grid", <?=json_encode($dataSource)?>, columns, options);
        });

    });
</script>