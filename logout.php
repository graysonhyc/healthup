<?php

session_start();
unset($_SESSION['login']);
unset($_SESSION['user']);
unset($_SESSION['user_id']);
unset($_SESSION['userrank']);
unset($_SESSION['userlv1']);
unset($_SESSION['userlv2']);
unset($_SESSION['userlv3']);
unset($_SESSION['userlv4']);
unset($_SESSION['userscore']);
header('Location: http://localhost/wordpress/');
exit(0);

?>