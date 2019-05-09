<?php
session_start();
$score = 0;

//1_q
if (isset($_POST['1_q'])) {
    if ($_POST['1_q'] === "B") {
        $_SESSION['1_q'] = "Correct answer!";
        //setcookie('1st_q',"Correct answer!");
        $score = $score + 10;
    } else {
        $_SESSION['1_q'] = "Wrong answer!";
        //setcookie('1st_q',"Wrong answer!");
    }
} else {
    $_SESSION['1_q'] = "Answer is missing!";
    //setcookie('1st_q',"Answer is missing!");
}

//2_q
if (isset($_POST['2_q'])) {
    if ($_POST['2_q'] === "B") {
        $_SESSION['2_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['2_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['2_q'] = "Answer is missing!";
}

//3_q
if (isset($_POST['3_q']) && $_POST['3_q'] !== "") {
    if ($_POST['3_q'] === "compass" || $_POST['3_q'] === "Compass") {
        $_SESSION['3_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['3_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['3_q'] = "Answer is missing!";
}

//4_q
if ((isset($_POST['4_q_1']) && $_POST['4_q_1'] !== "") && (isset($_POST['4_q_2']) && $_POST['4_q_2'] !== "")) {
    if ($_POST['4_q_1'] === "endurance" && $_POST['4_q_2'] === "strength") {
        $_SESSION['4_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['4_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q'] = "Answer is missing!";
}

//5_q
if (isset($_POST['5_q'])) {
    if ($_POST['5_q'] === "B") {
        $_SESSION['5_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['5_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['5_q'] = "Answer is missing!";
}

$_SESSION['exercises_lv3_score'] = $score;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_exercisesquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["exercises_lv3_score"] <= $score) {
        mysql_query("UPDATE wp_exercisesquizscore SET `exercises_lv3_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}
header ('Location: http://localhost/wordpress/level-3-exercises/');

?>