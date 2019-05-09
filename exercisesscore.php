<?php
session_start();
$GLOBALS['rank'] = 1;

$GLOBALS['userrank'] = 0;
$GLOBALS['userlv1'] = 0;
$GLOBALS['userlv2'] = 0;
$GLOBALS['userlv3'] = 0;
$GLOBALS['userlv4'] = 0;
$GLOBALS['userscore'] = 0;
$GLOBALS['tempscore'] = 0;
$GLOBALS['repeatedtimes'] = 0;

$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
$dbRecords = mysql_query("SELECT display_name, exercises_lv1_score , exercises_lv2_score , exercises_lv3_score , exercises_lv4_score,
exercises_lv1_score + exercises_lv3_score + exercises_lv4_score + exercises_lv2_score AS Score
FROM wp_exercisesquizscore ORDER BY Score DESC", $dbLocalhost) or die("Problem reading table: " . mysql_error());
echo "<table border='1'>
    <tr><th>Rank</th>
        <th>User</th>
        <th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Total score</th>";

while ($arrRecords = mysql_fetch_array($dbRecords)) {
    echo "<tr>";
    if ($GLOBALS['tempscore'] == $arrRecords['Score']) {
        $GLOBALS['repeatedtimes']++;
        $GLOBALS['rank'] = ($GLOBALS['rank'] - $GLOBALS['repeatedtimes']);
        $GLOBALS['repeatedscore'] = true;
        $_SESSION['repeateduserrank'] = "repeated";

    } else {
        $GLOBALS['repeatedtimes'] = 0;
    }
    echo "<td>" . $GLOBALS['rank'] . "</td>";
    if ($GLOBALS['repeatedscore'] == true) {
        $GLOBALS['rank'] = ($GLOBALS['rank'] + $GLOBALS['repeatedtimes']);
        $GLOBALS['repeatedscore'] = false;
    }
    echo "<td>" . $arrRecords['display_name'] . "</td>";
    if ($arrRecords['display_name'] === $_SESSION['user']) {
        if (isset($_SESSION['repeateduserrank'])) {
            $GLOBALS['userrank'] = ($GLOBALS['rank'] - $GLOBALS['repeatedtimes']);
            unset($_SESSION['repeateduserrank']);
        } else {
            $GLOBALS['userrank'] = $GLOBALS['rank'];
        }
        $GLOBALS['userlv1'] = $arrRecords['exercises_lv1_score'];
        $GLOBALS['userlv2'] = $arrRecords['exercises_lv2_score'];
        $GLOBALS['userlv3'] = $arrRecords['exercises_lv3_score'];
        $GLOBALS['userlv4'] = $arrRecords['exercises_lv4_score'];

    }
    echo "<td>" . $arrRecords['exercises_lv1_score'] . "</td>";
    echo "<td>" . $arrRecords['exercises_lv2_score'] . "</td>";
    echo "<td>" . $arrRecords['exercises_lv3_score'] . "</td>";
    echo "<td>" . $arrRecords['exercises_lv4_score'] . "</td>";
    echo "<td>" . $arrRecords['Score'] . "</td>";
    $GLOBALS['tempscore'] =  $arrRecords['Score'];
    if ($arrRecords['display_name'] === $_SESSION['user']) {
        $GLOBALS['userscore'] = $arrRecords['Score'];
    }
    $GLOBALS['rank']++;
    echo "</tr>";
}
if ($GLOBALS['userrank'] == 0) {
    $GLOBALS['userrank'] = "Unclassified";
}
echo "<tr><td>".'<span style="color:blue">'.$GLOBALS['userrank']."</span></td><td>".
    '<span style="color:blue">'.$_SESSION['user']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userlv1']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userlv2']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userlv3']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userlv4']."</span></td><td>".
    '<span style="color:blue">'.$GLOBALS['userscore']."</span></td></tr>";
echo "</table>";

$_SESSION['exercisesuserrank'] = $GLOBALS['userrank'];
$_SESSION['exercisesuserlv1'] = $GLOBALS['userlv1'];
$_SESSION['exercisesuserlv2'] = $GLOBALS['userlv2'];
$_SESSION['exercisesuserlv3'] = $GLOBALS['userlv3'];
$_SESSION['exercisesuserlv4'] = $GLOBALS['userlv4'];
$_SESSION['exercisesuserscore'] = $GLOBALS['userscore'];

header('Location: /wordpress/scoreboard-exercises/');
exit(0);
?>