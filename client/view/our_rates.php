<h1 class="content_title">Our Rates</h1>
<div id="notification"></div>
<div id="content">
    <div id="rate_grid" class="slickgrid_table" style="width: 900px; height:600px"></div>
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
    "jquery-ui",)
    , $JS_DEPS)?>, function () {

        var rate_grid;
        var columns = [
            {id: "destination", name: "Destination", field: "destination", width: 500},
            {id: "rate", name: "Rate", field: "rate", width: 300}
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
                    client_id: <?=$client_id?>,
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