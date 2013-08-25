<?php
if(isset($_REQUEST["info"])) {
    echo "<div class='msg_bar'><img class='notify_icon' src='../images/information.png'/>".$_REQUEST["info"]."</div>";
}
if(isset($_REQUEST["warning"])) {
    echo "<div class='msg_bar'><img class='notify_icon' src='../images/exclamation.png'/>".$_REQUEST["warning"]."</div>";
}
if(isset($_REQUEST["error"])) {
    echo "<div class='msg_bar'><img class='notify_icon' src='../images/exclamation-red.png'/>".$_REQUEST["error"]."</div>";
}
?>
