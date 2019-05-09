<?php
session_start();

if (empty($_POST['height']) || empty($_POST['weight'])) {
    $_SESSION['bmi_error'] = "Required fields are missing!";
    header('Location: /wordpress/bmi-calculator/');
    exit(0);

} else if (!is_numeric($_POST['height']) || !is_numeric($_POST['weight'])) {
    $_SESSION['bmi_error'] = "Please enter numbers!";
    header('Location: /wordpress/bmi-calculator/');
    exit(0);
}
$height = $_POST['height']/100 ;
$weight = $_POST['weight'];

$bmi = round($weight/($height*$height),1);
    $_SESSION['bmi'] = $bmi;

if ($bmi <18.5 ) {
    $_SESSION['bmi_info'] = "You are underweight!";
} else if (($bmi>=18.5) && ($bmi <=24.9)) {
    $_SESSION['bmi_info'] = "You are in normal condition.";
} else if ($bmi >= 30) {
    $_SESSION['bmi_info'] = "You are obese!";
} else {
    $_SESSION['bmi_info'] = "You are overweight!";
}
    header('Location: /wordpress/bmi-calculator/');
    exit(0);

?>