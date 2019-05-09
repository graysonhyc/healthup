<?php
session_start();
$score = 0;

//1_q
if (isset($_POST['1_q'])) {
    if ($_POST['1_q'] === "D") {
        $_SESSION['1_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['1_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['1_q'] = "Answer is missing!";
}

//2_q
if (isset($_POST['2_q'])) {
    if ($_POST['2_q'] === "A") {
        $_SESSION['2_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['2_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['2_q'] = "Answer is missing!";
}

//3_q
if (isset($_POST['3_q_1']) || isset($_POST['3_q_2']) || isset($_POST['3_q_3'])
    || isset($_POST['3_q_4']) || isset($_POST['3_q_5']) || isset($_POST['3_q_6'])  ) {

    if (isset($_POST['3_q_1']) && isset($_POST['3_q_2']) && isset($_POST['3_q_4']) && isset($_POST['3_q_5'])
        && !isset($_POST['3_q_3']) && !isset($_POST['3_q_6']) && !isset($_POST['3_q_7'])) {
        $_SESSION['3_q'] = "Correct Answer!";
        $score = $score +10;
    } else {
        $_SESSION['3_q'] = "Wrong Answer!";
    }
} else {
    $_SESSION['3_q'] = "Answer is missing!";
}

//4_q
if (isset($_POST['4_q'])) {
    if ($_POST['4_q'] === "A") {
        $_SESSION['4_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['4_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q'] = "Answer is missing!";
}

//5_q
if (isset($_POST['5_q']) && $_POST['5_q'] !== "") {
    if ($_POST['5_q'] === "weight") {
        $_SESSION['5_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['5_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['5_q'] = "Answer is missing!";
}

$_SESSION['eating_lv2_score'] =  $score;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_eatingquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["eating_lv2_score"] <= $score) {
        mysql_query("UPDATE wp_eatingquizscore SET `eating_lv2_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}
header ('Location: http://localhost/wordpress/level-2-eating/');
?>