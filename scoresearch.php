<?php
session_start();

if (isset($_POST['searchscore'])) {
    $_SESSION['searchtarget'] = $_POST['searchscore'];
    header('Location:/wordpress/scoreboard-user-score/');
    exit(0);
}


?>