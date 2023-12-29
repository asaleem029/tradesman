<?php

DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tradesman');
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');

// Create connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}

$db -> set_charset("utf8");
?>

