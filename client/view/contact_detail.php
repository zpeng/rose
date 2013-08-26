<h1 class="content_title">Contact Detail</h1>
<div id="notification"></div>
<div id="content">
    <form id="clientDetailUpdateForm" method="post">
        <input type="hidden" value="<? echo $client_id ?>" name="client_id" id="client_id"/>
        <table width="500" border="0" class="general_table">
            <tr>
                <td width="150" align="right"><b>Client Email: </b></td>
                <td><?= $client->getEmail() ?></td>
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


        $("#client_update_btn").button();
        jQuery('form#clientDetailUpdateForm').submit(function () {
            $.ajax({
                url: SERVER_URL + "client/control/client_detail_update.php",
                type: "POST",
                data: {
                    client_id: $("#client_id").val(),
                    firstname: $("#firstname").val(),
                    lastname: $("#lastname").val(),
                    telephone: $("#telephone").val(),
                    mobile: $("#mobile").val(),
                    address_1: $("#address_1").val(),
                    address_2: $("#address_2").val(),
                    postcode: $("#postcode").val(),
                    city: $("#city").val(),
                    country: $("#country").val()
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        jQuery("div#notification").html("<span class='info'> You contact detail has been updated successfully!</span>");
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


