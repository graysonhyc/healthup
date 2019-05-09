<?php
session_start();
$score = 0;

//1st q
if (isset($_POST['1_q'])) {
    if ($_POST['1_q'] === "C") {
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
if (isset($_POST['2_q_1']) || isset($_POST['2_q_2']) || isset($_POST['2_q_3'])
    || isset($_POST['2_q_4']) || isset($_POST['2_q_5']) || isset($_POST['2_q_6'])  ) {

    if (isset($_POST['2_q_1']) && isset($_POST['2_q_2']) && isset($_POST['2_q_4']) && isset($_POST['2_q_5'])
        && !isset($_POST['2_q_3']) && !isset($_POST['2_q_6'])) {
        $_SESSION['2_q'] = "Correct Answer!";
        $score = $score +10;
    } else {
        $_SESSION['2_q'] = "Wrong Answer!";
    }
} else {
    $_SESSION['2_q'] = "Answer is missing!";
}

//3_q_1
if (isset($_POST['3_q_1']) && $_POST['3_q_1'] !== "") {
    if ($_POST['3_q_1'] == "True") {
        $_SESSION['3_q_1'] = "Correct Answer!";
        $score = $score + 5;
    } else if ($_POST['3_q_1'] !== "Please select"){
        $_SESSION['3_q_1'] = "Wrong Answer!";
    } else {
        $_SESSION['3_q_1'] = "Answer is missing!";
    }
}

//3_q_2
if (isset($_POST['3_q_2']) && $_POST['3_q_2'] !== "") {
    if ($_POST['3_q_2'] == "False") {
        $_SESSION['3_q_2'] = "Correct Answer!";
        $score = $score + 5;
    } else if ($_POST['3_q_2'] !== "Please select"){
        $_SESSION['3_q_2'] = "Wrong Answer!";
    } else {
        $_SESSION['3_q_2'] = "Answer is missing!";
    }
}

//4_q_1
if (isset($_POST['4_q_1']) && $_POST['4_q_1'] !== "") {
    if ($_POST['4_q_1'] === "moodiness") {
        $_SESSION['4_q_1'] = "Correct answer!";
        $score = $score + 5;
    } else {
        $_SESSION['4_q_1'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q_1'] = "Answer is missing!";
}

//4_q_2
if (isset($_POST['4_q_2']) && $_POST['4_q_2'] !== "") {
    if ($_POST['4_q_2'] === "routine") {
        $_SESSION['4_q_2'] = "Correct answer!";
        $score = $score + 5;
    } else {
        $_SESSION['4_q_2'] = "Wrong answer!";
    }
} else {
    $_SESSION['4_q_2'] = "Answer is missing!";
}

//5_q
if (isset($_POST['5_q'])) {
    if ($_POST['5_q'] === "B") {
        $_SESSION['5_q'] = "Correct answer!";
        //setcookie('1st_q',"Correct answer!");
        $score = $score + 10;
    } else {
        $_SESSION['5_q'] = "Wrong answer!";
        //setcookie('1st_q',"Wrong answer!");
    }
} else {
    $_SESSION['5_q'] = "Answer is missing!";
    //setcookie('1st_q',"Answer is missing!");
}

$_SESSION['rest_lv3_score'] = $score;


//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_restquizscore
WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());
if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["rest_lv3_score"] <= $score) {
        mysql_query("UPDATE wp_restquizscore SET `rest_lv3_score`='" . $score . "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}
header ('Location: http://localhost/wordpress/level-3-rest/');
?>
