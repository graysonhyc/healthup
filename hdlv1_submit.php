<?php
session_start();
$score = 0;

//1_q
if (isset($_POST['1_q'])) {
    if ($_POST['1_q'] === "A") {
        $_SESSION['1_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['1_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['1_q'] = "Answer is missing!";
}

if (isset($_POST['2_q_1']) || isset($_POST['2_q_2']) || isset($_POST['2_q_3'])
    || isset($_POST['2_q_4']) || isset($_POST['2_q_5'])) {

    if (isset($_POST['2_q_1']) && isset($_POST['2_q_2']) && isset($_POST['2_q_3']) && !isset($_POST['2_q_4'])
        && !isset($_POST['2_q_5'])) {
        $_SESSION['2_q'] = "Correct Answer!";
        $score = $score +10;
    } else {
        $_SESSION['2_q'] = "Wrong Answer!";
    }
} else {
    $_SESSION['2_q'] = "Answer is missing!";
}


//3_q
if (isset($_POST['3_q'])) {
    if ($_POST['3_q'] === "A") {
        $_SESSION['3_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['3_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['3_q'] = "Answer is missing!";
}

//4_q
if (isset($_POST['4_q'])) {
    if ($_POST['4_q'] === "B") {
        $_SESSION['4_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['4_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q'] = "Answer is missing!";
}

//5_q
if (!empty($_POST['5_q_1']) && !empty($_POST['5_q_2'])) {
    if ($_POST['5_q_1'] == "seasonal" && $_POST['5_q_2'] =="affective") {
        $_SESSION['5_q'] = "Correct answer!";
        $score += 10;
    } else {
        $_SESSION['5_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['5_q'] = "Answer is missing!";
}

$_SESSION['hd_lv1_score'] = $score;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_hdquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["hd_lv1_score"] <= $score) {
        mysql_query("UPDATE wp_hdquizscore SET `hd_lv1_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}

if ($arrRecords == "") {
    mysql_query("INSERT INTO wp_hdquizscore ( ID, display_name, hd_lv1_score) VALUES
    ('" . $_SESSION['user_id'] . "','" . $_SESSION['user'] . "','" . $score . "')");
} else {
    header ('Location: /wordpress/level-1-handling-depression/');
}
header ('Location: /wordpress/level-1-handling-depression/');



?>