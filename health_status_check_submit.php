<?php
session_start();
$errorstate = false;
$score = 0;

if (isset($_POST['bd'])){
    $bd = $_POST['bd'];
    switch ($bd) {
        case "A":
            $_SESSION['bd'] = "Good :)";
            $score += 2;
            break;
        case "B":
            $_SESSION['bd'] = "Fair :)";
            $score += 1;
            break;
        case "C":
            $_SESSION['bd'] = "Poor :(";
    }
} else {
    $_SESSION['bd'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['cd'])){
    $cd = $_POST['cd'];
    switch ($cd) {
        case "A":
            $_SESSION['cd'] = "Good :)";
            $score += 2;
            break;
        case "B":
            $_SESSION['cd'] = "Fair :)";
            $score += 1;
            break;
        case "C":
            $_SESSION['cd'] = "Poor :(";
    }
} else {
    $_SESSION['cd'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['sleep_hr']) && $_POST['sleep_hr'] !== "Please Select") {
    $hr = $_POST['sleep_hr'];
    switch ($hr) {

        case ($hr <= 6):
            $_SESSION['sleep_warning'] = "You have insufficient sleep :(";
            break;
        case ($hr >=7 && $hr <=11 ):
            $_SESSION['sleep_warning'] = "You have sufficient sleep :)";
            $score += 2;
            break;
        case ($hr >= 12):
            $_SESSION['sleep_warning'] = "You sleep too much :(";
            break;
    }
} else {
    $_SESSION['sleep_warning'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['de'])) {
    $de = $_POST['de'];
    switch($de) {
        case "A":
            $_SESSION['de'] = "You have too few exercises :(";
            break;
        case "B":
            $_SESSION['de'] = "Just right amount of exercises :)";
            $score += 2;
            break;
        case "C":
            $_SESSION['de'] = "Alright :)";
            $score += 1;
            break;
        case "D":
            $_SESSION['de'] = "You have too many exercises :(";
    }
} else {
    $_SESSION['de'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['dew'])) {
    $dew = $_POST['dew'];
    switch($dew) {
        case "A":
            $_SESSION['dew'] = "You have too few exercises :(";
            break;
        case "B":
            $_SESSION['dew'] = "Alright :)";
            $score += 1;
            break;
        case "C":
            $_SESSION['dew'] = "Just right amount of exercises :)";
            $score += 2;
            break;
        case "D":
            $_SESSION['dew'] = "You have too many exercises :(";
    }
} else {
    $_SESSION['dew'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['fs'])){
    $fs = $_POST['fs'];
    switch ($fs) {
        case "A":
            $_SESSION['fs'] = "Poor :(";
            break;
        case "B":
            $_SESSION['fs'] = "Fair :)";
            $score += 1;
            break;
        case "C":
            $_SESSION['fs'] = "Good :)";
            $score += 2;
            break;
        case "D":
            $_SESSION['fs'] = "Good :)";
            $score += 2;
    }
} else {
    $_SESSION['fs'] = "Please select your choice!";
    $errorstate = true;
}

if (isset($_POST['fh'])){
    $fh = $_POST['fh'];
    switch ($fh) {
        case "A":
            $_SESSION['fh'] = "Poor :(";
            break;
        case "B":
            $_SESSION['fh'] = "Fair :)";
            $score += 1;
            break;
        case "C":
            $_SESSION['fh'] = "Good :)";
            $score += 2;
            break;
        case "D":
            $_SESSION['fh'] = "Good :)";
            $score += 2;
    }
} else {
    $_SESSION['fh'] = "Please select your choice!";
    $errorstate = true;
}

if ($errorstate == true) {
    header('Location: /wordpress/health-status-check/');
    exit(0);
} else { //Total mark : 14
    if ($score >= 7 && $score <= 10) {
        $_SESSION['status'] = "You health status is normal :)";
    } else if ($score > 10) {
        $_SESSION['status'] = "You health status is good :)";
    } else {
        $_SESSION['status'] = "You health status is poor :(";
    }
    header('Location: /wordpress/health-status-check/');
    exit(0);
}



?>