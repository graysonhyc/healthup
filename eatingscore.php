<?php
session_start();

//Initialization
$rank = 1; $userrank = 0;

$userlv1 = 0; $userlv2 = 0;
$userlv3 = 0; $userlv4 = 0;

$userscore = 0; $tempscore = 0;

$repeatedtimes = 0;
$repeatedscore = false; $repeateduserrank = false;

//db connection
$dbLocalhost = mysql_connect("localhost", "root", "")
or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost)
or die("Could not find database: " . mysql_error());

//Fetching scores (ordered)
$dbRecords = mysql_query

("SELECT display_name, eating_lv1_score , eating_lv2_score , eating_lv3_score , eating_lv4_score,
eating_lv1_score + eating_lv3_score + eating_lv4_score + eating_lv2_score AS Score
FROM wp_eatingquizscore ORDER BY Score DESC", $dbLocalhost)

or die("Problem reading table: " . mysql_error());

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

    if ($tempscore == $arrRecords['Score']) {
        $repeatedtimes++;
        $rank = ($rank - $repeatedtimes);
        $repeatedscore = true;
        $repeateduserrank = true;
    } else {
        $repeatedtimes = 0;
    }

    echo "<td>" . $rank . "</td>";

    if ($repeatedscore) {
        $rank = ($rank + $repeatedtimes);
        $repeatedscore = false;
    }

    echo "<td>" . $arrRecords['display_name'] . "</td>";

    if ($arrRecords['display_name'] === $_SESSION['user']) {
        if ($repeateduserrank) {
            $userrank = ($rank - $repeatedtimes);
            $repeateduserrank = false;
        } else {
            $userrank = $rank;
        }
        $userlv1 = $arrRecords['eating_lv1_score'];
        $userlv2 = $arrRecords['eating_lv2_score'];
        $userlv3 = $arrRecords['eating_lv3_score'];
        $userlv4 = $arrRecords['eating_lv4_score'];
    }

    echo "<td>" . $arrRecords['eating_lv1_score'] . "</td>";
    echo "<td>" . $arrRecords['eating_lv2_score'] . "</td>";
    echo "<td>" . $arrRecords['eating_lv3_score'] . "</td>";
    echo "<td>" . $arrRecords['eating_lv4_score'] . "</td>";
    echo "<td>" . $arrRecords['Score'] . "</td>";
    $tempscore =  $arrRecords['Score'];

    if ($arrRecords['display_name'] === $_SESSION['user']) {
        $userscore = $arrRecords['Score'];
    }

    $rank++;
    echo "</tr>";
}
if ($userrank == 0) {
    $userrank = "Unclassified";
}

$_SESSION['eatinguserrank'] = $userrank;
$_SESSION['eatinguserlv1'] = $userlv1;
$_SESSION['eatinguserlv2'] = $userlv2;
$_SESSION['eatinguserlv3'] = $userlv3;
$_SESSION['eatinguserlv4'] = $userlv4;
$_SESSION['eatinguserscore'] = $userscore;

header('Location: /wordpress/scoreboard-eating/');
exit(0);

?>