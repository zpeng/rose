<h1 class="content_title">Call Log Upload</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\Client;

    $csv_file = $_REQUEST['csv_file'];
    $client_id = $_REQUEST['client_id'];
    $client = new Client();
    $client->loadByID($client_id);

    $num_rows = 0;
    $charge = 0;
    $margin = floatval($client->getMargin());
    $array_from_csv = readCSV($csv_file);
    $dataSource = array();
    foreach ($array_from_csv as $data) {
        if ($data[0] != "") {
            ++$num_rows;
            $charge = $charge + floatval(trim($data[3])) * (1 + $margin);

            array_push($dataSource, array(
                "timestamp" => trim($data[0]),
                "call_number" => trim($data[1]),
                "duration" => str_replace(" ", "", $data[2]),
                "base_rate" => trim($data[3])
            ));
        }
    }

    $remain_balance = floatval($client->getBalance()) - $charge;
    ?>
    <div class="important_announce">
        <b>Make sure you check the following items before proceeding:
            <br> - Is the following client who intend to upload the call log for ?
            <br> - Is the total number of records matching with you original excel sheet or csv file ?
            <br> - Is the calculation for the charge and balance correct ?
            <br> - Is the data appears in the table correct? Is the data structure correct?
        </b>
    </div>


    <form id="csvLogCallInsertForm" method="post" action="<?= SERVER_URL ?>admin/control/call_log_insert.php">
        <input type="hidden" value="<? echo $client_id ?>" name="client_id" id="client_id"/>
        <input type="hidden" value="<? echo $csv_file ?>" name="csv_file" id="csv_file"/>
        <table width="900" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Client Email: </b></td>
                <td><?=$client->getEmail()?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b>Client Name: </b></td>
                <td><?=$client->getFullName()?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b>Current Balance: </b></td>
                <td><?=$client->getBalance()?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b>Location of the Call Log File: </b></td>
                <td><?=$csv_file?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b> Number of Records</b>: </b></td>
                <td><?=$num_rows?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b> Total Charge</b>: </b></td>
                <td><?=$charge?></td>
            </tr>
            <tr>
                <td width="150" align="right"><b> Balance after Charge</b>: </b></td>
                <td><?=$remain_balance?></td>
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
                {id: "timestamp", name: "Call Timestamp", field: "timestamp", width: 200},
                {id: "call_number", name: "Calling Number", field: "call_number", width: 200},
                {id: "duration", name: "Duration", field: "duration", width: 200},
                {id: "base_rate", name: "Base Charge", field: "base_rate", width: 200}
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