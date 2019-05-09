<?php
session_start();

//Set the date received to meaningful variables
date_default_timezone_set("Asia/Hong_Kong");
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$fullname = $_POST['fullname'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$bio = $_POST['bio'];
$registertime = date("Y-m-d") . " "  . date("h:i:sa");
$errorstate = false;

    // Field Presence check
    if (empty($username)) { //if (!isset($username) || $username === "")
        $_SESSION['reg_usname_err'] = "Username is missing!";
        //setcookie('reg_usname_err',"Username is missing!");
        $errorstate = true;
    // Format check
    } else if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $username)) {
        $_SESSION['reg_usname_err'] = "Only letters and numbers are allowed and 5-20 characters are required!";
        $errorstate = true;
    }

    // db connection
    $dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
    mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
    $dbRecords = mysql_query("SELECT * FROM wp_users
    WHERE BINARY user_login ='" . $username . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());

    // Check whether username exists in the database
    if ($arrRecords = mysql_fetch_assoc($dbRecords)) {
        $_SESSION['reg_usname_err'] = "Username exists!";
        $errorstate = true;
    }

    // Field Presence check (Password)
    if (empty($password)) {
        $_SESSION['reg_passwd_err'] = "Password is missing!";
        $errorstate = true;
    } else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&*()-_=+[]|;:<>,.?`~]{8,12}$/', $password)) {
        $_SESSION['reg_passwd_err'] = "At least one letter and one number and 8-50 characters are required!";
        $errorstate = true;
    }

    // Field Presence check (Confirmation Password)
    if (empty($confirm_password)) {
        //((isset($password) && $password !== "") && (empty($confirm_password) || $confirm_password === ""))
        $_SESSION['reg_con_passwd_err'] = "Please confirm your password!";
        $errorstate = true;
        // Data verification (Input data twice)
    } else if ($password !== $confirm_password) {
        $_SESSION['reg_con_passwd_err'] = "Passwords do not match!";
        $errorstate = true;
    }

    $dbRecords = mysql_query("SELECT * FROM wp_users
    WHERE BINARY display_name ='" . $fullname . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
    // Field Presence check (Fullname)
    if (empty($fullname)) {
        $_SESSION['reg_fullname_err'] = "Nickname is missing!";
        $errorstate = true;
    } else if ($arrRecords = mysql_fetch_assoc($dbRecords)) {
        $_SESSION['reg_fullname_err'] = "This nickname has been used already!";
        $errorstate = true;
    }


    // Format Check (Email)
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['reg_email_err'] = "Email format is wrong!";
        $errorstate = true;
    } else if (!empty($email)) {
        $dbRecords = mysql_query("SELECT * FROM wp_users
        WHERE user_email ='" . $email . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
        if ($arrRecord = mysql_fetch_assoc($dbRecords)) {
            $_SESSION['reg_email_err'] = "Email exists!";
            $errorstate = true;
        }
    }


    // Redirect to registration page if error presents
    if ($errorstate == true) {
        header('Location: http://localhost/wordpress/registraion/');
        exit(0);
    }

    // Successfully signed up
    mysql_query("INSERT INTO wp_users
               (user_login, user_pass, user_nicename, user_gender, user_dob, user_email, user_registered, display_name, user_bio)
    VALUES ('" . $username . "','" . md5($password) . "','" . $username . "','" . $gender . "','" . $dob . "','"
            . $email ."','" . $registertime ."','". $fullname."','" . $bio . "')");

    // Login automatically
    $_SESSION['login'] = "success";
    $_SESSION['user'] = $fullname;
    $dbRecords = mysql_query("SELECT ID FROM wp_users
    WHERE user_login='" . $username . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
    if ($arrRecord = mysql_fetch_assoc($dbRecords)) {
        $_SESSION['user_id'] = $arrRecord['ID'];
    }

// Redirect to main page
header('Location: http://localhost/wordpress/welcome/');
exit(0);
?>