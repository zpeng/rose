<?php
// this is always required
require_once('../includes/bootstrap.php');

require_once(BASE_PATH . 'client/control/auth.php');
?>


<?= outputHTMLStart("Client Billing Self Service System", $JS_GLOBAL, $CSS_GLOBAL) ?>


<? include_once('view/header_bar.php') ?>
    <div id='main_content'>
        <?
        // load the left menu
        include_once(BASE_PATH . "client/view/left_panel.php");
        // load the content
        include_once(BASE_PATH . "client/view/right_panel.php");
        ?>
        <br class="clear"/>
    </div>

<? include_once('view/footer.php') ?>
<?= outputHTMLEnd() ?>