<?php
session_start();

$old_password = $_POST['old_password'];


if (empty($old_password)){
    $_SESSION['change_old_pw_err'] = "Your old password is missing!";
    header('Location: http://localhost/wordpress/change-your-password-1/');
    exit(0);
}

$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
$dbRecords = mysql_query("SELECT * FROM wp_users
WHERE ID ='" . $_SESSION['user_id'] . "' AND user_pass ='" . md5($old_password) . "'", $dbLocalhost)
or die("Problem reading table: " . mysql_error());

if ($arrRecord = mysql_fetch_assoc($dbRecords)) {
    $_SESSION['old_pw_success'] = "Old password identified, please enter your new password.";
    header('Location: http://localhost/wordpress/change-your-password-2/');
    exit(0);
} else {
    $_SESSION['change_old_pw_err'] = "Incorrect old password!";
    header('Location: http://localhost/wordpress/change-your-password-1/');
    exit(0);
}
?>