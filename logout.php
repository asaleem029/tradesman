<?php
include 'includes/helper.php';

session_start();
unset($_SESSION);
unset($_SESSION['users']);

myAlert("You're logged out", "index.php");
