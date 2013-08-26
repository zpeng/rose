<h1 class="content_title">Payment List</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\ClientManager;
    $clientManager = new ClientManager();
    $client_list_ds = $clientManager->getActiveClientlistDataSource();

    $client_list_ds["data"]["Show All Clients"] = "0";
    $client_list_ds["selected"]["Show All Clients"] = "0";
    ?>
    <a id="add_new_payment" class="anchor_button" href="#">Add New Payment</a>
    <br class="clear">
    <table style="width: 900px;" border="0">
        <tr>
            <td style="width: 500px"><b>Choose User: </b><?echo createDropdownList("client_filter_list", "client_filter_list", "", "", "1", $client_list_ds);?></td>
            <td style="width: 200px; text-align: right"><b>Start Date: </b><input name="start_date" id="start_date" style="width: 120px;"/></td>
            <td style="width: 200px; text-align: right"><b>End Date:</b> <input name="end_date" id="end_date" style="width: 120px;"/></td>
        </tr>
    </table>
    <div id="payment_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>


<div id="dialog" title="Create New Admin User">
    <form id="createPaymentForm" action="<?= SERVER_URL ?>admin/control/payment_create.php" method='post'>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Client: </b></td>
                <td>
                    <?echo createDropdownList("client_dropdown", "client_dropdown", "", "", "1", $clientManager->getActiveClientlistDataSource());?>
                </td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Amount: </b></td>
                <td><input name="amount" id="amount" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Payment Method: </b></td>
                <td><input name="payment_method" id="payment_method" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Remark: </b></td>
                <td><textarea  name="remark" id="remark" cols="40" rows="3"></textarea></td>
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

        $("a#add_new_payment").button();
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
        $('a#add_new_payment').click(function () {
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

        var payment_grid;
        var columns = [
            {id: "id", name: "ID", field: "id", width: 60},
            {id: "client_name", name: "Client Name", field: "client_name", width: 120},
            {id: "timestamp", name: "Payment Time", field: "timestamp", width: 120},
            {id: "amount", name: "Amount", field: "amount", width: 80},
            {id: "actual_cost", name: "Actual Cost", field: "actual_cost", width: 80},
            {id: "payment_method", name: "Payment Method", field: "payment_method", width: 120},
            {id: "remark", name: "Remark", field: "remark", width: 150}
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
                url: SERVER_URL + "admin/control/fetch_service.php",
                type: "POST",
                data: {
                    operation_id: "fetch_payment_table",
                    client_id: $("#client_filter_list option:selected").val(),
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