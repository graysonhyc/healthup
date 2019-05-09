<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

//Field presence check
if (empty($username) OR empty($password)) {
    $_SESSION['login_err'] = "Required fields are missing!";
    header('Location: http://localhost/wordpress/login/');
    exit(0);
}

// db connection
    $dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
    mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
    $dbRecords = mysql_query("SELECT ID, user_login, display_name FROM wp_users
    WHERE BINARY user_login ='" . $username . "' AND user_pass ='" . md5($password) . "'", $dbLocalhost)
    or die("Problem reading table: " . mysql_error());

    if ($arrRecord = mysql_fetch_assoc($dbRecords)) {
        $_SESSION['login'] = 'success';
        $_SESSION['user'] = $arrRecord['display_name'];
        $_SESSION['user_id'] = $arrRecord['ID'];
        header('Location: http://localhost/wordpress/welcome/');
        exit(0);
    } else {
        $_SESSION['login_err'] = "Incorrect username or password!";
        header('Location: http://localhost/wordpress/login/');
        exit(0);
    }
?>