<?php
if (isset($_SESSION["session"])) {

    unset($_SESSION["session"]);
    
    redirect('/login.php?msg=logged_out');
} else {
    redirect('/login.php');
}
exit();