<?php
/*
Plugin Name: Session
Author: Dick Ho

*/
add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}
?>