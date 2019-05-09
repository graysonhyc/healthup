<?php
session_start();
$errorstate = false;

$new_password = $_POST['new_password'];
$con_new_password = $_POST['con_new_password'];

if (empty($new_password)) {
    $_SESSION['change_new_pw_err'] = "Your new password is missing!";
    $errorstate = true;
} else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&*()-_=+[]|;:<>,.?`~]{8,12}$/', $new_password)) {
    $_SESSION['change_new_pw_err'] = "At least one letter and one number and 8-50 characters are required!";
    $errorstate = true;
}
if ((!empty($new_password)) && (empty($con_new_password))) {
    $_SESSION['change_con_new_pw_err'] = "Please confirm your password!";
    $errorstate = true;
} else if ($new_password !== $con_new_password) {
    $_SESSION['change_con_new_pw_err'] = "New passwords do not match!";
    $errorstate = true;
}

if ($errorstate == true) {
    header('Location: /wordpress/change-your-password-2/');
    exit(0);
}

$dbLocalhost = mysql_connect("localhost", "root", "")
or die("Could not connect: " . mysql_error());

mysql_select_db("healthquizup", $dbLocalhost)
or die("Could not find database: " . mysql_error());

mysql_query("UPDATE wp_users SET `user_pass`='" . md5($new_password) .
    "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);

    $_SESSION['change_info'] = "Password changed successfully!";
    unset($_SESSION['old_pw_success']);

    header('Location: http://localhost/wordpress/change-your-password-2/');
    exit(0);

?>