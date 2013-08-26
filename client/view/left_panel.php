<?
use includes\classes\Client;
$client_id = $_SESSION['user_id'];
$client = new Client();
$client->loadByID($client_id);

?>
<div id="left_panel">
    <div class="balance_div">
        Your Balance: <span class="balance"><?=number_format($client->getBalance(),2)?> <?=$client->getCurrency()?></span>
    </div>

    <div id="left_vertical_menu">
        <ul class="top-level">
            <li><a href="<?=SERVER_URL."client/index.php?view=call_history"?>">Call History</a></li>
            <li><a href="<?=SERVER_URL."client/index.php?view=payment_history"?>">Payment History</a></li>
            <li><a href="<?=SERVER_URL."client/index.php?view=our_rates"?>">Our Rates</a></li>
            <li><a href="<?=SERVER_URL."client/index.php?view=contact_detail"?>">Contact Detail</a></li>
            <li><a href="<?=SERVER_URL."client/index.php?view=password_update"?>">Update Password</a></li>
        </ul>
    </div>
</div>
