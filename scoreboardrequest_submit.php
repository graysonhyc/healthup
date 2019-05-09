<?php
session_start();

if (isset($_POST['scoreboardrequest'])) {
    $request = $_POST['scoreboardrequest'];
    switch ($request) {
        case "Eating":
            header('Location: /wordpress/eatingscore.php');
            exit(0);
        case "Rest":
            header('Location: /wordpress/restscore.php');
            exit(0);
        case "Exercises":
            header('Location: /wordpress/exercisesscore.php');
            exit(0);
        case "Handling Depression":
            header('Location: /wordpress/hdscore.php');
            exit(0);
        default:
            header('Location: /wordpress/totalscore.php');
            exit(0);
    }
}

?>
