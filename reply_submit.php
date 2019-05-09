<?php
session_start();
if (!empty($_POST['threadno']) && $_POST['threadno'] !== 0) {
    $GLOBALS['replyno']  = $_POST['threadno'];
} else {
    $_SESSION['reply_err'] = "Please enter a thread number you would like to reply to!";
    header('Location: /wordpress/make-a-reply/');
    exit(0);
}

// Image validation
if(!empty($_FILES['image']['type'])) {

    if ( !preg_match( '/gif|png|x-png|jpeg/', $_FILES['image']['type']) ) {
        $_SESSION['image_err'] = "Only browser compatible images are allowed!";
        $errorstate=true;
    } else if ($_FILES['image']['size'] > 8388608 /*8MB*/) {
        $_SESSION['image_err'] = "Sorry, file size is too large!";
        $errorstate=true;
    } else {
        $GLOBALS['image']= addslashes($_FILES['image']['tmp_name']);
        $GLOBALS['name'] = addslashes($_FILES['image']['name']);
        $GLOBALS['image']= file_get_contents($GLOBALS['image']);
        $GLOBALS['image']= base64_encode($GLOBALS['image']);
    }
}

//Set the date received to meaningful variables
date_default_timezone_set("Asia/Hong_Kong");
$postime = date("Y-m-d") . " "  . date("h:i:sa");

$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_forum_questions WHERE question_id = '" . $GLOBALS['replyno'] . "'", $dbLocalhost)
or die("Problem reading table: " . mysql_error());


    if (!empty($_POST['reply']) && strlen($_POST['reply']) >= 20) {
        $validreply = $_POST['reply'];
    } else {
        $_SESSION['reply_err'] = "Please provide a meaningful reply!";
        $errorstate = true;
    }

if ($arrRecords = mysql_fetch_assoc($dbRecords)) {
} else {
    $_SESSION['reply_err'] = "Thread number does not exist!";
    $errorstate = true;
}

if ($errorstate) {
    header('Location: /wordpress/make-a-reply/');
    exit(0);
}

        mysql_query("INSERT INTO wp_forum_answers (ID, display_name, answers, answer_postime, question_id, answer_image_name, answer_images)
        VALUES ('" . $_SESSION['user_id'] . "','" . $_SESSION['user'] . "','" . $validreply . "','" . $postime . "',
        '" . $GLOBALS['replyno'] . "','" . $GLOBALS['name'] . "','" . $GLOBALS['image'] . "')")
        or die("Problem writing table: " . mysql_error());
        header('Location: /wordpress/discussion');
        exit(0);
?>