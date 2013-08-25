<?php
// this is always required
require_once('../includes/bootstrap.php');

require_once(BASE_PATH . 'admin/control/auth.php');
?>


<?= outputHTMLStart("Administration Login", $JS_GLOBAL, $CSS_GLOBAL) ?>


<? include_once('view/header_bar.php') ?>
    <div id='main_content'>
        <?
        // load the left menu
        include_once(BASE_PATH . "admin/view/left_panel.php");
        // load the content
        include_once(BASE_PATH . "admin/view/right_panel.php");
        ?>
        <br class="clear"/>
    </div>

<? include_once('view/footer.php') ?>
<?= outputHTMLEnd() ?>