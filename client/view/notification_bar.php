<?php
if(isset($_REQUEST["info"])) {
    echo "<div id='notification'><span class='info'>".$_REQUEST["info"]."</span>";
}
if(isset($_REQUEST["warning"])) {
    echo "<div id='notification'><span class='warning'/>".$_REQUEST["warning"]."</span>";
}
if(isset($_REQUEST["error"])) {
    echo "<div id='notification'><span class='error'/>".$_REQUEST["error"]."</span>";
}
?>
