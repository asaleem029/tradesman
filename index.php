<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user']['id'])) {
    include 'header.php';
} else {
    $page_title = "Welcome {$_SESSION['user']['name']}";
    include('home_header.php');
} ?>

<div class="container">
    <h1>Welcome to my lovely page</h1>
    <img src="img/innovation.jpg" />
</div>

<?php include("footer.php") ?>