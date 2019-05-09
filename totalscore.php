<?php
session_start();

$GLOBALS['rank'] = 1;

$GLOBALS['userrank'] = 0;
$GLOBALS['usereatingscore'] = 0;
$GLOBALS['userrestscore'] = 0;
$GLOBALS['userexercisesscore'] = 0;
$GLOBALS['userhdscore'] = 0;
$GLOBALS['userscore'] = 0;
$GLOBALS['tempscore'] = 0;
$GLOBALS['repeatedtimes'] = 0;


$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());

$dbRecords = mysql_query("SELECT wp_users.display_name , COALESCE(eating_lv1_score,0) + COALESCE(eating_lv2_score,0) + COALESCE(eating_lv3_score,0) + COALESCE(eating_lv4_score,0) AS Eating,
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
LEFT JOIN wp_hdquizscore ON wp_users.ID = wp_hdquizscore.ID ORDER BY Score DESC", $dbLocalhost) or die("Problem reading table: " . mysql_error());
echo "<table border='1'>
    <tr><th>Rank</th>
        <th>User</th>
        <th>Eating</th>
        <th>Rest</th>
        <th>Exercises</th>
        <th>Handling Depression</th>
        <th>Total score</th>";

while ($arrRecords = mysql_fetch_array($dbRecords)) {
    echo "<tr>";
    if ($arrRecords['Score'] == 0){
        $GLOBALS['temp'] = $GLOBALS['rank'];
        $GLOBALS['rank'] = "Unclassified";
        $GLOBALS['noattemptstate'] = true;
        $_SESSION['usernoattempt'] = "yes";
    } else if ($GLOBALS['tempscore'] == $arrRecords['Score']) {
        $GLOBALS['repeatedtimes']++;
        $GLOBALS['rank'] = ($GLOBALS['rank'] - $GLOBALS['repeatedtimes']);
        $GLOBALS['repeatedscore'] = true;
        $_SESSION['repeateduserrank'] = "repeated";
    } else {
        $GLOBALS['repeatedtimes'] = 0;
    }

    echo "<td>" . $GLOBALS['rank'] . "</td>";
    if ($GLOBALS['noattemptstate'] === true) {
        $GLOBALS['rank'] = $GLOBALS['temp'];
        $GLOBALS['noattemptstate'] = false;
    } else if ($GLOBALS['repeatedscore'] === true) {
        $GLOBALS['rank'] = ($GLOBALS['rank'] + $GLOBALS['repeatedtimes']);
        $GLOBALS['repeatedscore'] = false;
    }
    echo "<td>" . $arrRecords['display_name'] . "</td>";
    if ($arrRecords['display_name'] === $_SESSION['user']) {
        if (isset($_SESSION['repeateduserrank'])) {
            $GLOBALS['userrank'] = ($GLOBALS['rank'] - $GLOBALS['repeatedtimes']);
            unset($_SESSION['repeateduserrank']);
        } else if (isset($_SESSION['usernoattempt'])) {
            $GLOBALS['userrank'] = "Unclassified";
            unset($_SESSION['usernoattempt']);
        } else {
            $GLOBALS['userrank'] = $GLOBALS['rank'];
        }
        $GLOBALS['usereatingscore'] = $arrRecords['Eating'];
        $GLOBALS['userrestscore'] = $arrRecords['Rest'];
        $GLOBALS['userexercisesscore'] = $arrRecords['Exercises'];
        $GLOBALS['userhdscore'] = $arrRecords['HD'];
    }
    echo "<td>" . $arrRecords['Eating'] . "</td>";
    echo "<td>" . $arrRecords['Rest'] . "</td>";
    echo "<td>" . $arrRecords['Exercises'] . "</td>";
    echo "<td>" . $arrRecords['HD'] . "</td>";
    echo "<td>" . $arrRecords['Score'] . "</td>";
    $GLOBALS['tempscore'] =  $arrRecords['Score'];
    if ($arrRecords['display_name'] === $_SESSION['user']) {
        $GLOBALS['userscore'] = $arrRecords['Score'];
    }
    $GLOBALS['rank']++;
    echo "</tr>";
}

if ($GLOBALS['userscore'] == 0) {
    $GLOBALS['userrank'] = "Unclassified";
}
echo "<tr><td>".'<span style="color:blue">'.$GLOBALS['userrank']."</span></td><td>".
    '<span style="color:blue">'.$_SESSION['user']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['usereatingscore']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userrestscore']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userexercisesscore']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userhdscore']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userscore']."</span></td></tr>";
echo "</table>";

$_SESSION['totaluserrank'] = $GLOBALS['userrank'];
$_SESSION['totaleatingscore'] = $GLOBALS['usereatingscore'];
$_SESSION['totalrestscore'] = $GLOBALS['userrestscore'];
$_SESSION['totalexercisesscore'] = $GLOBALS['userexercisesscore'];
$_SESSION['totalhdscore'] = $GLOBALS['userhdscore'];
$_SESSION['totaluserscore'] = $GLOBALS['userscore'];

header('Location: /wordpress/scoreboard-total/');
exit(0);

?>