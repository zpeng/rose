<script id="html_select_template" type="text/x-jquery-tmpl">
    <select id="client_status_dropdown" name="client_status_dropdown">
        {{tmpl(data, {selectedId:selected_value }) "#html_option_template"}}
    </select>
</script>

<script id="html_option_template" type="text/x-jquery-tmpl">
    <option {{if value === $item.selectedId}} selected="selected"{{/if}} value="${value}">${label}</option>
</script>

<h1 class="content_title">Client List</h1>
<div id="notification"></div>
<div id="content">
    <a id="add_new_client" class="anchor_button" href="#" style="float: right; margin-right: 30px">Add New Client</a>
    <div id="client_status_div"></div>
    <br class="clear"/>
    <div id="client_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>

<div id="dialog" title="Create New Client">
    <br/>

    <form id="createClientForm" action="<?= SERVER_URL ?>admin/control/client_create.php" method='post'>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Client Email: </b></td>
                <td><input name="email" id="email" style="width: 200px;"/></td>
            </tr>
            <tr>
                <td width="150" align="right"><b>Password: </b></td>
                <td><input name="password" id="password" style="width: 200px;" type="password" /></td>
            </tr>

            <tr class="empty_table_row"><td></td><td></td></tr>
            <tr>
                <td width="150" align="right"><b>Firstname: </b></td>
                <td><input name="firstname" id="firstname" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Lastname: </b></td>
                <td><input name="lastname" id="lastname" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Telephone: </b></td>
                <td><input name="telephone" id="telephone" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Mobile: </b></td>
                <td><input name="mobile" id="mobile" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Address 1: </b></td>
                <td><input name="address_1" id="address_1" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Address 2: </b></td>
                <td><input name="address_2" id="address_2" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Postcode: </b></td>
                <td><input name="postcode" id="postcode" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>City: </b></td>
                <td><input name="city" id="city" style="width: 200px;"/></td>
            </tr>

            <tr>
                <td width="150" align="right"><b>Country: </b></td>
                <td><input name="country" id="country" style="width: 200px;"/></td>
            </tr>

            <tr class="empty_table_row"><td></td><td></td></tr>
            <tr>
                <td width="150" align="right"><b>Currency: </b></td>
                <td><select name="currency" id="currency" style="width: 200px;">
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
            </tr>


            <tr>
                <td width="150" align="right"><b>Margin: </b></td>
                <td><input name="margin" id="margin" style="width: 200px;" value="0.50"/></td>
            </tr>
            <tr class="empty_table_row"><td></td><td></td></tr>

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

        $("a#add_new_client").button();
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
        $('a#add_new_client').click(function () {
            $('#dialog').dialog('open');
            return false;
        });


        jQuery(function () {
            jQuery("#client_email").validate({
                expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                message: "Please enter a valid Email"
            });
            jQuery("#password").validate({
                expression: "if (VAL.length >= 8 && VAL) return true; else return false;",
                message: "Please enter a valid Password (the length of password must exceed 8 characters)"
            });

            jQuery("#margin").validate({
                expression: "if (VAL.match(/^\\d+(?:\\.\\d{1,2})?$/) && VAL) return true; else return false;",
                message: "Please enter a valid margin"
            });
        });


        //supplier status dorpdowm
        var model = {
            data: [
                { value: "Y", label: "Active" },
                { value: "N", label: "Inactive" }
            ],
            selected_value: "Y"
        };
        $("#html_select_template").tmpl(model).appendTo("#client_status_div" );


        var client_grid;
        var columns = [
            {id: "id", name: "ID", field: "id", width: 60},
            {id: "email", name: "Email", field: "email", width: 150},
            {id: "name", name: "Name", field: "name", width: 200},
            {id: "currency", name: "Currency", field: "currency", width: 100},
            {id: "balance", name: "Current Balance", field: "balance", width: 150},
            {id: "margin", name: "Margin", field: "margin", width: 100},
            {id: "action", name: "Action", field: "action", width: 60,
                formatter: linkFormatter = function (row, cell, value, columnDef, dataContext) {
                    return "<a class='icon_edit' title='Update Client Information' href='" + SERVER_URL + "admin/index.php?view=client_update&client_id=" +
                        dataContext['id'] + "' ></a>";
                }
            }
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
                    operation_id: "fetch_client_table",
                    is_active: $("#client_status_dropdown option:selected").val()
                },
                dataType: "json",
                success: function (data) {
                    client_grid = new Slick.Grid("#client_grid", data, columns, options);
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
        $("#client_status_dropdown").change(function(e) {
            fetch_data();
        });
    });
</script>