<?php
session_start();
$GLOBALS['score'] = 0;

function MC_q ($userans,$corrans,&$ansstat) {
    if ($userans === $corrans) {
        $ansstat = "Correct answer!";
        $GLOBALS['score'] += 10;
    } else if (empty($userans)) {
        $ansstat = "Answer is missing!";
    } else {
        $ansstat = "Wrong answer!";
    }
}

//1st_q
MC_q($_POST['1st_q'],"B",$_SESSION['1st_q']);
//2nd_q
MC_q($_POST['2nd_q'],"A",$_SESSION['2nd_q']);
//4th q
MC_q($_POST['4th_q'],"C",$_SESSION['4th_q']);



function TF_q ($userans,$corrans,&$ansstat) {
    if ($userans === $corrans) {
        $ansstat = "Correct answer!";
        $GLOBALS['score'] += 5;
    } else if ($userans == "Please select") {
        $ansstat = "Answer is missing!";
    } else {
        $ansstat = "Wrong answer!";
    }
}

//5th q1
TF_q($_POST['5th_q_1'],"False",$_SESSION['5th_q_1']);

//5th q2
TF_q($_POST['5th_q_2'],"True",$_SESSION['5th_q_2']);


//3rd q
if (isset($_POST['3rd_q_1']) || isset($_POST['3rd_q_2'])
      || isset($_POST['3rd_q_3']) || isset($_POST['3rd_q_4'])
      || isset($_POST['3rd_q_5']) || isset($_POST['3rd_q_6'])  ) {

    if (isset($_POST['3rd_q_1']) && isset($_POST['3rd_q_2'])
        && isset($_POST['3rd_q_4']) && isset($_POST['3rd_q_5'])
        && !isset($_POST['3rd_q_3']) && !isset($_POST['3rd_q_6'])) {

        $_SESSION['3rd_q'] = "Correct Answer!";
        $GLOBALS['score'] += 10;
    } else {
        $_SESSION['3rd_q'] = "Wrong Answer!";
    }
} else {
    $_SESSION['3rd_q'] = "Answer is missing!";
}

function fillblanks ($userans,$corrans,&$ansstat) {
    if ($userans === $corrans) {
        $ansstat = "Correct answer!";
        $GLOBALS['score'] += 10;
    } else if (empty($userans)) {
        $ansstat = "Answer is missing!";
    } else {
        $ansstat = "Wrong answer!";
    }
}



$_SESSION['eating_lv1_score'] =  $GLOBALS['score'];

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT * FROM wp_eatingquizscore

WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost)
or die("Problem reading table: " . mysql_error());

if ($arrRecords = mysql_fetch_assoc($dbRecords)){
    if ($arrRecords["eating_lv1_score"] <= $GLOBALS['score']) {
        mysql_query("UPDATE wp_eatingquizscore SET `eating_lv1_score`='" . $GLOBALS['score'] .
                    "' WHERE ID ='" . $_SESSION['user_id'] . "'", $dbLocalhost);
    }
}

if ($arrRecords == "") {
    mysql_query("INSERT INTO wp_eatingquizscore ( ID, display_name, eating_lv1_score) VALUES
    ('" . $_SESSION['user_id'] . "','" . $_SESSION['user'] . "','" . $GLOBALS['score'] . "')");

} else {
    header ('Location: http://localhost/wordpress/level-1-eating/');
}

header ('Location: http://localhost/wordpress/level-1-eating/');

?>