<h1 class="content_title">Call Log</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\ClientManager;
    $clientManager = new ClientManager();
    $client_list_ds = $clientManager->getActiveClientlistDataSource();

    $client_list_ds["data"]["Show All Clients"] = "0";
    $client_list_ds["selected"]["Show All Clients"] = "0";
    ?>
    <a id="upload_call_log" class="anchor_button" href="#">Upload Call Log</a>
    <br class="clear">
    <table style="width: 900px;" border="0">
        <tr>
            <td style="width: 500px"><b>Choose User: </b><?echo createDropdownList("client_filter_list", "client_filter_list", "", "", "1", $client_list_ds);?></td>
            <td style="width: 200px; text-align: right"><b>Start Date: </b><input name="start_date" id="start_date" style="width: 120px;"/></td>
            <td style="width: 200px; text-align: right"><b>End Date:</b> <input name="end_date" id="end_date" style="width: 120px;"/></td>
        </tr>
    </table>
    <div id="call_log_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>


<div id="dialog" title="Create New Admin User">
    <form id="createPaymentForm" action="<?= SERVER_URL ?>admin/control/call_log_upload.php" method="post"
          enctype='multipart/form-data'>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Client: </b></td>
                <td>
                    <?echo createDropdownList("client_dropdown", "client_dropdown", "", "", "1", $clientManager->getActiveClientlistDataSource());?>
                </td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Log File: </b></td>
                <td> <input name="csv_uploaded" id="csv_uploaded" type="file"/>
                    <br/>
                    <span>(Support Type: CSV.  Maximum file size: 2Mb)</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input name='Add' id="add_button" type='submit' value='Create'/>
                    <input name='Reset' id="reset_button" type='reset' value='Reset'/>
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
    "jquery-form-validate-css",
    "slickgrid-css")
    , $CSS_DEPS)?>);

    // load js
    head.js(<?=outputDependencies(
    array(
    "slickgrid",
    "jquery-ui",
    "jquery-tmpl",
    "jquery-form-validate")
    , $JS_DEPS)?>, function () {

        $("a#upload_call_log").button();
        $("#add_button").button();
        $("#reset_button").button();

        // Dialog
        $('#dialog').dialog({
            autoOpen: false, modal: true,
            width: 550,
            buttons: {
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });

        // Dialog Link
        $('a#upload_call_log').click(function () {
            $('#dialog').dialog('open');
            return false;
        });


        jQuery(function () {
            jQuery("#amount").validate({
                expression: "if (VAL.match(/^\\d+(?:\\.\\d{1,2})?$/) && VAL) return true; else return false;",
                message: "Please enter a valid amount"
            });
        });


        //date picker
        $("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#start_date").datepicker('setDate', '-1m');
        $("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#end_date").datepicker('setDate', '+1d');

        var call_log_grid;
        var columns = [
            {id: "id", name: "ID", field: "id", width: 80},
            {id: "client_name", name: "Client Name", field: "client_name", width: 150},
            {id: "call_number", name: "Calling At", field: "call_number", width: 150},
            {id: "timestamp", name: "Start At", field: "timestamp", width: 150},
            {id: "duration", name: "Duration", field: "duration", width: 150},
            {id: "base_rate", name: "Base Rate", field: "base_rate", width: 100},
            {id: "charge", name: "Our Charge", field: "charge", width: 100}
        ];
        var options = {
            enableCellNavigation: true,
            enableColumnReorder: false,
            forceFitColumns: true
        };

        //use ajax to load data source
        function fetch_data() {
            $.ajax({
                url: SERVER_URL + "admin/control/fetch_service.php",
                type: "POST",
                data: {
                    operation_id: "fetch_call_log_table",
                    client_id: $("#client_filter_list option:selected").val(),
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


        //when the supplier status dropdown selection is changed
        $("#client_filter_list").change(function (e) {
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