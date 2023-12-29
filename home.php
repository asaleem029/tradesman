<?php
session_start();

if (!isset($_SESSION['id'])) {
    require('includes/helper.php');
    load();
} else {
    $page_title = "Welcome {$_SESSION['name']}";
    include('home_header.php');
}
