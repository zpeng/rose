<div id="right_panel">
    <?php
    $view = "";
    if (isset($_REQUEST["view"]))
    {
        $view = secureRequestParameter($_REQUEST["view"]);
    }
    switch ($view) {
        case "call_history":
            include_once(BASE_PATH . 'client/view/call_history.php');
            break;

        case "payment_history":
            include_once(BASE_PATH . 'client/view/payment_history.php');
            break;

        case "our_rates":
            include_once(BASE_PATH . 'client/view/our_rates.php');
            break;

        case "contact_detail":
            include_once(BASE_PATH . 'client/view/contact_detail.php');
            break;

        case "password_update":
            include_once(BASE_PATH . 'client/view/password_update.php');
            break;

        default:
            include_once(BASE_PATH . 'client/view/call_history.php');
            break;
    }
    ?>
</div>
