<h1 class="content_title">Update Password</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\Admin;
    $admin_id = secureRequestParameter($_REQUEST["admin_id"]);
    $admin = new Admin();
    $admin->loadByID($admin_id);
    ?>
    <form id="AdminPasswordUpdateForm" method="post">
        <input type="hidden" value="<? echo $admin_id ?>" name="admin_id" id="admin_id" />
        <table class="general_table">
            <tr>
                <td width="150" align="right"><b>Email: </b></td>
                <td><? echo $admin->get_admin_email()?>
                </td>
            </tr>
            <tr>
                <td align="right"><b>New Password: </b></td>
                <td><input name="password" id="password" type="password" style="width: 200px;"/></td>
            </tr>
            <tr>
                <td align="right"><b>Confirm Password: </b></td>
                <td><input name="confirm_password" id="confirm_password" type="password" style="width: 200px;"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input name='update' id="password_update_btn" type='submit' value='update' title="update"/></td>
            </tr>
        </table>
    </form>
</div>
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
            $("#tabs").tabs();

            $("#password_update_btn").button();
            jQuery(function () {
                jQuery("#password").validate({
                    expression: "if (VAL.length >= 8 && VAL) return true; else return false;",
                    message: "Please enter a valid Password (the length of password must exceed 8 characters)"
                });
                jQuery("#confirm_password").validate({
                    expression: "if ((VAL == jQuery('#password').val()) && VAL) return true; else return false;",
                    message: "Confirm password field doesn't match the password field"
                });

                jQuery('form#AdminPasswordUpdateForm').validated(function () {
                    $.ajax({
                        url: SERVER_URL + "admin/control/admin_password_update.php",
                        type: "POST",
                        data: {
                            admin_id: $("#admin_id").val(),
                            password: $("#password").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.status == "success") {
                                jQuery("div#notification").html("<span class='info'>Password has been updated successfully!</span>");
                            } else {
                                jQuery("div#notification").html("<span class='error'>Unable to update the password. Try again please!</span>");
                            }
                        },
                        error: function (msg) {
                            ajaxFailMsg(msg);
                        }
                    });
                    return false;
                });
            });

        });
    </script>


