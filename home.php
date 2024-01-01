<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    require('includes/helper.php');
    load();
} else {
    $page_title = "Welcome {$_SESSION['user']['name']}";
    include('home_header.php');
}
