<?php
// this is always required
require_once('../includes/bootstrap.php');
?>

<?= outputHTMLStart("Administration Login", $JS_GLOBAL, $CSS_GLOBAL) ?>

<table border="0" cellpadding="0" cellspacing="0" class="login_table">
    <tr>
        <td class="login_table_top_bar" colspan="2">
            Administration Login
        </td>
    </tr>
    <tr>
        <td width="30%" class="login_table_left_panel" valign="middle" align="center">
            <img src="../images/locker.png" width="80" height="80"/>
        </td>
        <td class="login_table_right_panel">
            <form method='post' action='control/login.php'>
                <table width="300" border="0">
                    <tr>
                        <td colspan="2" height="50">
                            <?
                            include_once('view/notification_bar.php');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100" class="login_table_label">Email:</td>
                        <td><input id="email" name="email" class="login_table_input"/></td>
                    </tr>
                    <tr>
                        <td width="100" class="login_table_label">Password:</td>
                        <td><input id="password" name="password" type="password" class="login_table_input"/></td>
                    </tr>
                    <tr>
                        <td width="100" align="right"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="100" align="right"></td>
                        <td align="right">
                            <input id='Login' name='Login' type='submit' value='Login' title="Login"/>
                        </td>
                    </tr>

                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td class="login_table_footer" colspan="2">
            <b>&copy; 2013 Rose Telecom</b>
        </td>
    </tr>
</table>
<script>
    // load css
    head.js(<?=outputDependencies(
    array(
    "jquery-ui-css",
    "jquery-form-validate-css")
    , $CSS_DEPS)?>);

    // load js
    head.js(<?=outputDependencies(
    array(
    "jquery-ui",
    "jquery-form-validate")
    , $JS_DEPS)?>, function () {

        jQuery("#Login").button();

        jQuery(function () {
            jQuery("#email").validate({
                expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                message: "Please enter a valid Email"
            });
            jQuery("#password").validate({
                expression: "if (VAL.length >= 8 && VAL) return true; else return false;",
                message: "Please enter a valid Password (the length of password must exceed 8 characters)"
            });
        });

    });


</script>
<?= outputHTMLEnd(); ?>
