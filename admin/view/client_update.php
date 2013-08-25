<h1 class="content_title">Client Detail</h1>
<div id="notification"></div>
<div id="content">
    <?
    use includes\classes\Client;
    $client_id = secureRequestParameter($_REQUEST["client_id"]);
    $client = new Client();
    $client->loadByID($client_id);
    ?>
    <br/>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Update Detail</a></li>
            <li><a href="#tabs-2">Update Password</a></li>
        </ul>

        <div id="tabs-1">
            <form id="clientDetailUpdateForm" method="post">
                <input type="hidden" value="<? echo $client_id ?>" name="client_id" id="client_id"/>
                <table width="500" border="0" class="general_table">
                    <tr>
                        <td width="150" align="right"><b>Client Email: </b></td>
                        <td><input name="email" id="email" style="width: 200px;" value="<?= $client->getEmail() ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right"><b>Firstname: </b></td>
                        <td><input name="firstname" id="firstname" style="width: 200px;"
                                   value="<?= $client->getFirstname() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Lastname: </b></td>
                        <td><input name="lastname" id="lastname" style="width: 200px;"
                                   value="<?= $client->getLastname() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Telephone: </b></td>
                        <td><input name="telephone" id="telephone" style="width: 200px;"
                                   value="<?= $client->getTelephone() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Mobile: </b></td>
                        <td><input name="mobile" id="mobile" style="width: 200px;" value="<?= $client->getMobile() ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Address 1: </b></td>
                        <td><input name="address_1" id="address_1" style="width: 200px;"
                                   value="<?= $client->getAddress1() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Address 2: </b></td>
                        <td><input name="address_2" id="address_2" style="width: 200px;"
                                   value="<?= $client->getAddress2() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Postcode: </b></td>
                        <td><input name="postcode" id="postcode" style="width: 200px;"
                                   value="<?= $client->getPostcode() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>City: </b></td>
                        <td><input name="city" id="city" style="width: 200px;" value="<?= $client->getCity() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Country: </b></td>
                        <td><input name="country" id="country" style="width: 200px;"
                                   value="<?= $client->getCountry() ?>"/></td>
                    </tr>

                    <tr>
                        <td width="150" align="right"><b>Active: </b></td>
                        <td>
                            <?
                            $status_dataSource = array(
                                "data" => array(
                                    "Active" => "Y",
                                    "Inactive" => "N"
                                ));
                            $status_dataSource["selected"] = array($client->getActive() => $client->getActive());
                            echo createDropdownList("client_status_dropdown", "client_status_dropdown", "", "", "", $status_dataSource);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right"><b>Currency: </b></td>
                        <td><?
                            $currency_dataSource = array(
                                "data" => array(
                                    "EUR" => "EUR",
                                    "GBP" => "GBP"
                                ));
                            $currency_dataSource["selected"] = array($client->getCurrency() => $client->getCurrency());
                            echo createDropdownList("currency_dropdown", "currency_dropdown", "", "", "", $currency_dataSource);
                            ?>
                    </tr>
                    <tr>
                        <td width="150" align="right"><b>Margin: </b></td>
                        <td><input name="margin" id="margin" style="width: 200px;" value="<?= $client->getMargin() ?>"/>
                        </td>
                    </tr>
                    <tr class="empty_table_row">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input name='Update' id="client_update_btn" type='submit' value='Update'/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="tabs-2">
            <form id="clientPasswordUpdateForm" method="post">
                <input type="hidden" value="<? echo $client_id ?>" name="client_id" id="client_id"/>
                <table class="general_table">
                    <tr>
                        <td align="right"><b>New Password: </b></td>
                        <td><input name="password" id="password" type="password" style="width: 200px;"/></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Confirm Password: </b></td>
                        <td><input name="confirm_password" id="confirm_password" type="password" style="width: 200px;"/>
                        </td>
                    </tr>
                    <tr class="empty_table_row">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input name='update' id="password_update_btn" type='submit' value='update' title="update"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
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

            jQuery('form#clientPasswordUpdateForm').validated(function () {
                $.ajax({
                    url: SERVER_URL + "admin/control/client_password_update.php",
                    type: "POST",
                    data: {
                        client_id: $("#client_id").val(),
                        password: $("#password").val() },
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

        $("#client_update_btn").button();
        jQuery('form#clientDetailUpdateForm').submit(function () {
            $.ajax({
                url: SERVER_URL + "admin/control/client_detail_update.php",
                type: "POST",
                data: {
                    client_id: $("#client_id").val(),
                    email: $("#email").val(),
                    firstname: $("#firstname").val(),
                    lastname: $("#lastname").val(),
                    telephone: $("#telephone").val(),
                    mobile: $("#mobile").val(),
                    address_1: $("#address_1").val(),
                    address_2: $("#address_2").val(),
                    postcode: $("#postcode").val(),
                    city: $("#city").val(),
                    country: $("#country").val(),
                    status: $("#client_status_dropdown option:selected").val(),
                    currency: $("#currency_dropdown option:selected").val(),
                    margin: $("#margin").val()
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        jQuery("div#notification").html("<span class='info'> Client has been updated successfully!</span>");
                    } else {
                        jQuery("div#notification").html("<span class='error'>Unable to update the module subscription. Try again please!</span>");
                    }
                },
                error: function (msg) {
                    ajaxFailMsg(msg);
                }
            });
            return false;
        });

        jQuery('form#clientPasswordUpdateForm').validated(function () {
            $.ajax({
                url: SERVER_URL + "admin/control/client_password_update.php",
                type: "POST",
                data: {
                    client_id: $("#client_id").val(),
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
</script>


