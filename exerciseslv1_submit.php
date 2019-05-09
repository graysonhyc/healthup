<?php
session_start();
$score = 0;

//1_q
if (isset($_POST['1_q'])) {
    if ($_POST['1_q'] === "B") {
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
    if ($_POST['3_q'] === "Sit Backs" || $_POST['3_q'] === "Chair Squats" || $_POST['3_q'] === "Butterfly Breath"
        || $_POST['3_q'] === "sit backs" || $_POST['3_q'] === "chair squats" || $_POST['3_q'] === "butterfly breath"
        || $_POST['3_q'] === "Sit backs" || $_POST['3_q'] === "Chair squats" || $_POST['3_q'] === "Butterfly breath") {
        $_SESSION['3_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['3_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['3_q'] = "Answer is missing!";
}

//4_q
if (isset($_POST['4_q']) && $_POST['4_q'] !== "") {
    if ($_POST['4_q'] === "5") {
        $_SESSION['4_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['4_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q'] = "Answer is missing!";
}

//5_q
if (isset($_POST['5_q_1']) || isset($_POST['5_q_2']) || isset($_POST['5_q_3'])
    || isset($_POST['5_q_4']) || isset($_POST['5_q_5']) || isset($_POST['5_q_6'])  ) {

    if (isset($_POST['5_q_1']) && isset($_POST['5_q_2']) && isset($_POST['5_q_4']) && isset($_POST['5_q_5'])
        && !isset($_POST['5_q_3']) && !isset($_POST['5_q_6'])) {
        $_SESSION['5_q'] = "Correct Answer!";
        $score = $score +10;
    } else {
        $_SESSION['5_q'] = "Wrong Answer!";
    }
} else {
    $_SESSION['5_q'] = "Answer is missing!";
}

$_SESSION['exercises_lv1_score'] = $score;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_exercisesquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["exercises_lv1_score"] <= $score) {
        mysql_query("UPDATE wp_exercisesquizscore SET `exercises_lv1_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}

if ($arrRecords == "") {
    mysql_query("INSERT INTO wp_exercisesquizscore ( ID, display_name, exercises_lv1_score) VALUES
    ('" . $_SESSION['user_id'] . "','" . $_SESSION['user'] . "','" . $score . "')");
} else {
    header ('Location: http://localhost/wordpress/level-1-exercises/');
}
header ('Location: http://localhost/wordpress/level-1-exercises/');
?>





?>