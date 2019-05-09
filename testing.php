<?php
session_start();

$_SESSION['searchtarget'] = "SD";

function printprofile ($arrRecords) {
    $GLOBALS['user'] = $arrRecords['display_name'];
    echo '<h2 style="color:blue;">' .$GLOBALS['user']. '</h2>';
    if (!empty($arrRecords['user_bio'])) {
        echo '<span style="font-size:20px;">About Me: </span><br><Br>';
        echo $arrRecords['user_bio'];
    }
    echo "<br><br>";
    $score = $arrRecords['Score'];
    switch($score) {
        case ($score === 0):
            echo '<h2>Your level: <span style="color:green;">Turtle</span></h2>'.'<img src="/wordpress/infophoto/level/1.jpg"/>';
            break;
        case ($score < 50):
            echo '<h2>Level: <span style="color:green;">Turtle</span></h2>'.'<img src="/wordpress/infophoto/level/1.jpg"/>';
            break;
        case ($score >= 50 && $score < 150):
            echo '<h2>Level: <span style="color:green;">Rabbit</span></h2>'.'<img src="/wordpress/infophoto/level/2.jpg"/>';
            break;
        case ($score >= 150 && $score < 300):
            echo '<h2>Level: <span style="color:green;">Cat</span></h2>'.'<img src="/wordpress/infophoto/level/3.jpg"/>';
            break;
        case ($score >= 300 && $score < 500):
            echo '<h2>Level: <span style="color:green;">Dog</span></h2>'.'<img src="/wordpress/infophoto/level/4.jpg"/>';
            break;
        case ($score >= 500 && $score < 600):
            echo '<h2>Level: <span style="color:green;">Owl</span></h2>'.'<img src="/wordpress/infophoto/level/5.jpg"/>';
            break;
        case ($score >= 600 && $score < 750):
            echo '<h2>Level: <span style="color:green;">Penguin</span></h2>'.'<img src="/wordpress/infophoto/level/6.jpg"/>';
            break;
        case ($score >= 750 && $score <= 800):
            echo '<h2>Level: <span style="color:green;">Raven</span></h2>'.'<img src="/wordpress/infophoto/level/7.jpg"/>';
            break;
        default:
            echo '<h2>Your Level: <span style="color:green;">Admin</span></h2>'.'<img src="/wordpress/infophoto/level/8.gif"/>';
    }
    echo '<br>';
    echo '<h5 style="color:red;">'."Eating:".'</h5>';
    echo "<table border='1'>
    <tr><th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Total score</th>";
    echo "<tr>";
    echo "<td>".$arrRecords['usereat1']."</td>";
    echo "<td>".$arrRecords['usereat2']."</td>";
    echo "<td>".$arrRecords['usereat3']."</td>";
    echo "<td>".$arrRecords['usereat4']."</td>";
    echo "<td>".$arrRecords['Eating']."</td></tr></table>";
    echo "<br>";

    echo '<h5 style="color:orange;">'."Rest:".'</h5>';
    echo "<table border='1'>
    <tr><th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Total score</th>";
    echo "<tr>";
    echo "<td>".$arrRecords['userrest1']."</td>";
    echo "<td>".$arrRecords['userrest2']."</td>";
    echo "<td>".$arrRecords['userrest3']."</td>";
    echo "<td>".$arrRecords['userrest4']."</td>";
    echo "<td>".$arrRecords['Rest']."</td></tr></table>";
    echo "<br>";

    echo '<h5 style="color:purple;">'."Exercises:".'</h5>';
    echo "<table border='1'>
    <tr><th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Total score</th>";
    echo "<tr>";
    echo "<td>".$arrRecords['userex1']."</td>";
    echo "<td>".$arrRecords['userex2']."</td>";
    echo "<td>".$arrRecords['userex3']."</td>";
    echo "<td>".$arrRecords['userex4']."</td>";
    echo "<td>".$arrRecords['Exercises']."</td></tr></table>";
    echo "<br>";

    echo '<h5 style="color:green;">'."Handling Depression:".'</h5>';
    echo "<table border='1'>
    <tr><th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Total score</th>";
    echo "<tr>";
    echo "<td>".$arrRecords['userhd1']."</td>";
    echo "<td>".$arrRecords['userhd2']."</td>";
    echo "<td>".$arrRecords['userhd3']."</td>";
    echo "<td>".$arrRecords['userhd4']."</td>";
    echo "<td>".$arrRecords['HD']."</td></tr></table>";
    echo "<br>";

    echo '<h4>'."Total:".'</h4>';
    echo "<table border='3'>
   <tr><th>Eating</th>
        <th>Rest</th>
        <th>Exercises</th>
        <th>Handling Depression</th>
        <th>Total score</th>";
    echo "<tr>";
    echo "<td>".$arrRecords['Eating']."</td>";
    echo "<td>".$arrRecords['Rest']."</td>";
    echo "<td>".$arrRecords['Exercises']."</td>";
    echo "<td>".$arrRecords['HD']."</td>";
    echo "<td>".$arrRecords['Score']."</td></tr></table>";
    echo "<br>";
}

$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
$dbRecords = mysql_query("SELECT wp_users.display_name , wp_users.user_bio, COALESCE(eating_lv1_score,0) AS usereat1, COALESCE(eating_lv2_score,0) as usereat2, COALESCE(eating_lv3_score,0) as usereat3, COALESCE(eating_lv4_score,0) as usereat4,
COALESCE(rest_lv1_score,0) as userrest1, COALESCE(rest_lv2_score,0) as userrest2, COALESCE(rest_lv3_score,0) as userrest3, COALESCE(rest_lv4_score,0) as userrest4, COALESCE(exercises_lv1_score,0) as userex1, COALESCE(exercises_lv2_score,0) as userex2, COALESCE(exercises_lv3_score,0) as userex3, COALESCE(exercises_lv4_score,0) as userex4,
COALESCE(hd_lv1_score,0) as userhd1, COALESCE(hd_lv2_score,0) as userhd2, COALESCE(hd_lv3_score,0) as userhd3, COALESCE(hd_lv4_score,0) as userhd4, COALESCE(eating_lv1_score,0) + COALESCE(eating_lv2_score,0) + COALESCE(eating_lv3_score,0) + COALESCE(eating_lv4_score,0) AS Eating,
COALESCE(rest_lv1_score,0) + COALESCE(rest_lv2_score,0)+ COALESCE(rest_lv3_score,0) + COALESCE(rest_lv4_score,0) AS Rest,
COALESCE(exercises_lv1_score,0) + COALESCE(exercises_lv2_score,0) + COALESCE(exercises_lv3_score,0) + COALESCE(exercises_lv4_score,0) AS Exercises,
COALESCE(hd_lv1_score,0) + COALESCE(hd_lv2_score,0) + COALESCE(hd_lv3_score,0) + COALESCE(hd_lv4_score,0) AS HD,
(COALESCE(eating_lv1_score,0) + COALESCE(eating_lv2_score,0) + COALESCE(eating_lv3_score,0) + COALESCE(eating_lv4_score,0)
+ COALESCE(rest_lv1_score,0) + COALESCE(rest_lv2_score,0)+ COALESCE(rest_lv3_score,0) + COALESCE(rest_lv4_score,0)
+ COALESCE(exercises_lv1_score,0) + COALESCE(exercises_lv2_score,0) + COALESCE(exercises_lv3_score,0) + COALESCE(exercises_lv4_score,0)
+ COALESCE(hd_lv1_score,0) + COALESCE(hd_lv2_score,0) + COALESCE(hd_lv3_score,0) + COALESCE(hd_lv4_score,0)) AS Score
FROM wp_users
LEFT JOIN wp_eatingquizscore ON wp_users.ID = wp_eatingquizscore.ID
LEFT JOIN wp_restquizscore ON wp_users.ID = wp_restquizscore.ID
LEFT JOIN wp_exercisesquizscore ON wp_users.ID = wp_exercisesquizscore.ID
LEFT JOIN wp_hdquizscore ON wp_users.ID = wp_hdquizscore.ID WHERE wp_users.display_name = '" . $_SESSION['searchtarget'] . "'", $dbLocalhost) or die("Problem reading table: " . mysql_error());

if ($arrRecords = mysql_fetch_assoc($dbRecords)) {
    printprofile($arrRecords);
    unset($_SESSION['searchtarget']);
} else {
    echo '<C><h1 style="color:red;">'. "User does not exist!". '</h1></C>';
}

?>