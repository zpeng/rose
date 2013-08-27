<?php
$CSS_GLOBAL = array(
    "global-css" => "css/style.css"
);


$CSS_DEPS = array(
    "jquery-ui-css" => array("external/js/jquery-ui-1.10.2.custom/css/custom-theme/jquery-ui-1.10.2.custom.css"),
    "jquery-form-validate-css" => array("external/js/jquery-form-validate/jquery.validate.css"),
    "slickgrid-css" => array("external/js/SlickGrid/slick.grid.css",
        //"external/js/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css",
        "external/js/jquery-ui-1.10.2.custom/css/custom-theme/jquery-ui-1.10.2.custom.css")
);

/*
 * The following dependencies will be loaded by force
 */
$JS_GLOBAL = array(
    "global_constants" => "includes/global_constants.js",
    "jquery-1.9.1" => "external/js/jquery-1.9.1/jquery-1.9.1.min.js",
    "headJs" => "external/js/headJs/head.min.js"
    //"underscore-1.4.4" => "external/js/underscore-1.4.4/underscore-min.js",
    //"backbone-1.0.0" => "external/js/backbone-1.0.0/backbone-min.js"
);

/*
 * The following dependencies will be loaded on demand
 */
$JS_DEPS = array(
    "jquery-ui" => array(
        "external/js/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js"
    ),

    "jquery-form-validate" => array(
        "external/js/jquery-form-validate/jquery.validate.js",
        "external/js/jquery-form-validate/jquery.validation.functions.js"
    ),

    "jquery-ui-timepicker" => array("external/js/jquery-plugin/jquery-ui-timepicker-addon.js"),

    "slickgrid" => array(
        "external/js/SlickGrid/lib/jquery-1.7.min.js",
        "external/js/SlickGrid/lib/jquery.event.drag-2.2.js",
        "external/js/SlickGrid/lib/jquery.event.drop-2.2.js",
        "external/js/SlickGrid/slick.core.js",
        "external/js/SlickGrid/slick.grid.js",
        "external/js/SlickGrid/slick.dataview.js",
        "external/js/SlickGrid/slick.formatters.js",
        //"external/js/SlickGrid/slick.editors.js",
    ),

    "jquery-tmpl" => array(
        "external/js/jquery-tmpl/jquery.tmpl.min.js"
    )

);

$GLOBAL_DEPS = array(
    "shared_php" => array(
        "php" => array(
            "DatabaseUtils" => "includes/utils/database_utils.php",
            "GlobalFunction" => "includes/utils/global_functions.php",
            "PageBuilder" => "includes/utils/page_builder.php",
            "HtmlWidgets" => "includes/utils/html_widgets.php",
            "pdf" => "external/php/MPDF57/mpdf.php"
        )
    )
)

?>
