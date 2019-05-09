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
$dbRecords = mysql_query("SELECT display_name, rest_lv1_score , rest_lv2_score , rest_lv3_score , rest_lv4_score,
rest_lv1_score + rest_lv3_score + rest_lv4_score + rest_lv2_score AS Score
FROM wp_restquizscore ORDER BY Score DESC", $dbLocalhost) or die("Problem reading table: " . mysql_error());
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
        $GLOBALS['userlv1'] = $arrRecords['rest_lv1_score'];
        $GLOBALS['userlv2'] = $arrRecords['rest_lv2_score'];
        $GLOBALS['userlv3'] = $arrRecords['rest_lv3_score'];
        $GLOBALS['userlv4'] = $arrRecords['rest_lv4_score'];

    }
    echo "<td>" . $arrRecords['rest_lv1_score'] . "</td>";
    echo "<td>" . $arrRecords['rest_lv2_score'] . "</td>";
    echo "<td>" . $arrRecords['rest_lv3_score'] . "</td>";
    echo "<td>" . $arrRecords['rest_lv4_score'] . "</td>";
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

$_SESSION['restuserrank'] = $GLOBALS['userrank'];
$_SESSION['restuserlv1'] = $GLOBALS['userlv1'];
$_SESSION['restuserlv2'] = $GLOBALS['userlv2'];
$_SESSION['restuserlv3'] = $GLOBALS['userlv3'];
$_SESSION['restuserlv4'] = $GLOBALS['userlv4'];
$_SESSION['restuserscore'] = $GLOBALS['userscore'];

header('Location: /wordpress/scoreboard-rest/');
exit(0);



?>