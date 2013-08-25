<h1 class="content_title">Rate List</h1>
<div id="notification"></div>
<div id="content">
    <a id="upload_new_rate" class="anchor_button" href="#" style="float: right; margin-right: 30px">Upload New Rates</a>
    <br class="clear"/>

    <div id="rate_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
</div>

<div id="dialog" title="Upload New Rate CSV File">
    <br/>

    <form id="uploadRateForm" action="<?= SERVER_URL ?>admin/control/rate_upload.php" method="post"
          enctype='multipart/form-data'>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Rate CSV File: </b></td>
                <td> <input name="csv_uploaded" id="csv_uploaded" type="file"/>
                    <br/>
                    <span>(Support Type: CSV.  Maximum file size: 2Mb)</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input name='Upload' id="upload_button" type='submit' value='Upload'/>
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
    "jquery-form-validate")
    , $JS_DEPS)?>, function () {

        $("a#upload_new_rate").button();
        $("#upload_button").button();
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
        $('a#upload_new_rate').click(function () {
            $('#dialog').dialog('open');
            return false;
        });


        var rate_grid;
        var columns = [
            {id: "destination", name: "Destination", field: "destination", width: 500},
            {id: "rate", name: "Rate", field: "rate", width: 300}
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
                    operation_id: "fetch_rate_table"
                },
                dataType: "json",
                success: function (data) {
                    rate_grid = new Slick.Grid("#rate_grid", data, columns, options);
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

    });
</script>