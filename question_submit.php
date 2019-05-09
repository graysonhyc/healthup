<?php
session_start();
$errorstate = false;

//Set the date received to meaningful variables
date_default_timezone_set("Asia/Hong_Kong");
$postime = date("Y-m-d") . " "  . date("h:i:sa");

// db connection
$dbLocalhost = mysql_connect("localhost", "root", "")
or die("Could not connect: " . mysql_error());

mysql_select_db("healthquizup", $dbLocalhost)
or die("Could not find database: " . mysql_error());

// Image validation
if(!empty($_FILES['image']['type'])) {

    if ( !preg_match( '/gif|png|x-png|jpeg/', $_FILES['image']['type']) ) {
        $_SESSION['image_err'] = "Only browser compatible images are allowed!";
        $errorstate = true;
    } else if ($_FILES['image']['size'] > 8388608 /*8MB*/) {
        $_SESSION['image_err'] = "Sorry, file size is too large!";
        $errorstate = true;
    } else {
        $GLOBALS['image']= addslashes($_FILES['image']['tmp_name']);
        $GLOBALS['name'] = addslashes($_FILES['image']['name']);
        $GLOBALS['image']= file_get_contents($GLOBALS['image']);
        $GLOBALS['image']= base64_encode($GLOBALS['image']);
    }
}

// Thread validation
if (!empty($_POST['question']) && strlen($_POST['question']) >= 20 ) {
    $validquestion = $_POST['question'];
} else {
    $_SESSION['question_err'] = "Please provide a meaningful question!";
    $errorstate = true;
}

if ($errorstate) {
    header('Location: /wordpress/discussion-2/');
    exit(0);
}

    mysql_query("INSERT INTO wp_forum_questions
    (ID, display_name, questions, question_postime, question_image_name,question_images)
    VALUES ('" . $_SESSION['user_id'] . "','" . $_SESSION['user'] . "','"
            . $validquestion ."','" . $postime . "','" .$GLOBALS['name']."','".$GLOBALS['image']."')");
    header('Location: /wordpress/discussion');
    exit(0);
?>