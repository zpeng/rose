<script id="html_select_template" type="text/x-jquery-tmpl">
    <select id="admin_status_dropdown" name="admin_status_dropdown">
        {{tmpl(data, {selectedId:selected_value }) "#html_option_template"}}
    </select>
</script>

<script id="html_option_template" type="text/x-jquery-tmpl">
    <option {{if value === $item.selectedId}} selected="selected"{{/if}} value="${value}">${label}</option>
</script>

<h1 class="content_title">Admin List</h1>
<div id="notification"></div>
<div id="content">
    <a id="add_new_admin" class="anchor_button" href="#" style="float: right; margin-right: 30px">Add New Admin User</a>
    <div id="admin_status_div"></div>
    <br class="clear"/>
    <div id="admin_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>

<div id="dialog" title="Create New Admin User">
    <br/>

    <form id="createAdminForm" action="<?= SERVER_URL ?>admin/control/admin_create.php" method='post'>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Admin Email: </b></td>
                <td><input name="admin_email" id="admin_email" style="width: 200px;"/></td>
            </tr>
            <tr>
                <td width="150" align="right"><b>Password: </b></td>
                <td><input name="password" id="password" style="width: 200px;" type="password" /></td>
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

        $("a#add_new_admin").button();
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
        $('a#add_new_admin').click(function () {
            $('#dialog').dialog('open');
            return false;
        });


        jQuery(function () {
            jQuery("#admin_email").validate({
                expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                message: "Please enter a valid Email"
            });
            jQuery("#password").validate({
                expression: "if (VAL.length >= 8 && VAL) return true; else return false;",
                message: "Please enter a valid Password (the length of password must exceed 8 characters)"
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
        $("#html_select_template").tmpl(model).appendTo("#admin_status_div" );


        var admin_grid;
        var columns = [
            {id: "id", name: "ID", field: "id", width: 100},
            {id: "email", name: "Email", field: "email", width: 500},
            {id: "is_active", name: "Is Active", field: "is_active", width: 100},
            {id: "action", name: "Action", field: "action", width: 100,
                formatter: linkFormatter = function (row, cell, value, columnDef, dataContext) {
                    return "<a class='icon_edit' title='Update Admin Password' href='" + SERVER_URL + "admin/index.php?view=admin_update&admin_id=" +
                        dataContext['id'] + "' ></a>";
                }
            }
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
                    operation_id: "fetch_admin_table",
                    is_active: $("#admin_status_dropdown option:selected").val()
                },
                dataType: "json",
                success: function (data) {
                    admin_grid = new Slick.Grid("#admin_grid", data, columns, options);
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
        $("#admin_status_dropdown").change(function(e) {
            fetch_data();
        });
    });
</script>