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
if (isset($_POST['3_q'])) {
    if ($_POST['3_q'] === "D") {
        $_SESSION['3_q'] = "Correct answer!";
        $score = $score + 10;
    } else {
        $_SESSION['3_q'] = "Wrong answer!";
    }
} else {
    $_SESSION['3_q'] = "Answer is missing!";
}

//4_q_1
if (!empty($_POST['4_q_1'])) {
    if ($_POST['4_q_1'] == "positive") {
        $score += 5;
        $_SESSION['4_q_1'] = "Correct Answer!";
    } else {
        $_SESSION['4_q_1'] = "Wrong Answer!";
    }
} else {
    $_SESSION['4_q_1'] = "Answer is missing!";
}

//4_q_2
if (!empty($_POST['4_q_2'])  || !empty($_POST['4_q_3'])) {
    if (($_POST['4_q_2'] == "self") && ($_POST['4_q_3'] == "esteem")) {
        $score += 5;
        $_SESSION['4_q_2'] ="Correct Answer!";
    } else {
        $_SESSION['4_q_2'] = "Wrong Answer!";
    }
} else {
    $_SESSION['4_q_2'] = "Answer is missing!";
}

//5_q_1
if (isset($_POST['5_q_1'])) {
    $first = $_POST['5_q_1'];
    switch ($first) {
        case "Seasons and Daylight":
            $score += 2;
            $_SESSION['5_q_1'] = "Correct Answer!";
            break;
        case "Please select":
            $_SESSION['5_q_1'] = "Answer is missing!";
            break;
        default:
            $_SESSION['5_q_1'] = "Wrong Answer!";
    }
}

//5_q_2
if (isset($_POST['5_q_2'])) {
    $second = $_POST['5_q_2'];
    switch ($second) {
        case "Health Conditions and Hormonal Changes":
            $score += 2;
            $_SESSION['5_q_2'] = "Correct Answer!";
            break;
        case "Please select":
            $_SESSION['5_q_2'] = "Answer is missing!";
            break;
        default:
            $_SESSION['5_q_2'] = "Wrong Answer!";
    }
}
//5_q_3
if (isset($_POST['5_q_3'])) {
    $third = $_POST['5_q_3'];
    switch ($third) {
        case "Family and Social Environment":
            $score += 2;
            $_SESSION['5_q_3'] = "Correct Answer!";
            break;
        case "Please select":
            $_SESSION['5_q_3'] = "Answer is missing!";
            break;
        default:
            $_SESSION['5_q_3'] = "Wrong Answer!";
    }
}
//5_q_4
if (isset($_POST['5_q_4'])) {
    $fourth = $_POST['5_q_4'];
    switch ($fourth) {
        case "Life Events":
            $score += 2;
            $_SESSION['5_q_4'] = "Correct Answer!";
            break;
        case "Please select":
            $_SESSION['5_q_4'] = "Answer is missing!";
            break;
        default:
            $_SESSION['5_q_4'] = "Wrong Answer!";
    }
}


//5_q_5
if (isset($_POST['5_q_5'])) {
    $fifth = $_POST['5_q_5'];
    switch ($fifth) {
        case "Family and Social Environment":
            $score += 2;
            $_SESSION['5_q_5'] = "Correct Answer!";
            break;
        case "Please select":
            $_SESSION['5_q_5'] = "Answer is missing!";
            break;
        default:
            $_SESSION['5_q_5'] = "Wrong Answer!";
    }
}

$_SESSION['hd_lv3_score'] =  $score;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_hdquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["hd_lv3_score"] <= $score) {
        mysql_query("UPDATE wp_hdquizscore SET `hd_lv3_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}
header ('Location: http://localhost/wordpress/level-3-handling-depression/');

?>