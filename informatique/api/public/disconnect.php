<?php
if (isset($_SESSION["session"])) {

    unset($_SESSION["session"]);
    session_destroy();

    redirect('/login.php?msg=logged_out');
} else {
    redirect('/login.php');
}
exit();
