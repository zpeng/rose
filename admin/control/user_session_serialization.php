<?php

use includes\classes\UserSession;

if (!isset ($_SESSION['user_session'])) {
    $s_user_session = new UserSession($_SESSION['user_name']);
    unset ($_SESSION['$configManager']);
    $_SESSION['user_session'] = serialize($s_user_session);
} else {
    $str = unserialize($_SESSION['user_session']);
    $s_user_session = UserSession::cast($str);

    unset ($_SESSION['user_session']);
    $_SESSION['user_session'] = serialize($s_user_session);
}
?>