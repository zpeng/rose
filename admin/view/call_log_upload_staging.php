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
    foreach ($array_from_csv as $data) {
        if ($data[0] != "") {
            ++$num_rows;
            $charge = $charge + floatval($data[3]) * (1 + $margin);
        }
    }

    $remain_balance = floatval($client->getBalance()) - $charge;
    ?>


    <form id="csvLogCallInsertForm" method="post" action="<?= SERVER_URL ?>admin/control/call_log_insert.php">
        <input type="hidden" value="<? echo $client_id ?>" name="client_id" id="client_id"/>
        <input type="hidden" value="<? echo $csv_file ?>" name="csv_file" id="csv_file"/>
        <table width="500" border="0" class="general_table">
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
            <tr class="empty_table_row">
                <td></td>
                <td></td>
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
                <td></td>
                <td>
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
    "jquery-ui-css")
    , $CSS_DEPS)?>);

    // load js
    head.js(<?=outputDependencies(
    array(
    "jquery-ui")
    , $JS_DEPS)?>, function () {
        $("#call_log_proceed_btn").button();
    });
</script>