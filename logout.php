<?php
include 'includes/helper.php';

session_start();
unset($_SESSION);

myAlert("You're logged out", "index.php");
