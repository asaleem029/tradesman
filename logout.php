<?php
include 'includes/helper.php';

if (!isset($_SESSION)) {
    session_start();
}

session_unset();

myAlert("You're logged out", "index.php");
