<div id="right_panel">
    <?php
    $view = "";
    if (isset($_REQUEST["view"]))
    {
        $view = secureRequestParameter($_REQUEST["view"]);
    }
    switch ($view) {
        case "admin_list":
            include_once(BASE_PATH . 'admin/view/admin_list.php');
            break;
        case "admin_update":
            include_once(BASE_PATH . 'admin/view/admin_update.php');
            break;
        default:
            include_once(BASE_PATH . 'admin/view/admin_list.php');
            break;
    }
    ?>
</div>