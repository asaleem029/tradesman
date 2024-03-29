<?php
ob_start();
session_start();
?>
<!-- beginning of includes\home-header.html -->
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= !empty($_SESSION['user']) ? "Welcome " . $_SESSION['user']['name'] : "Innovation Center"; ?>
	</title>
	<link rel="stylesheet" href="css/foundation.min.css">
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" href="css/signin.css">
	<link rel="stylesheet" href="css/find_trademan.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="js/jquery-min.js"></script>
	<script src="js/find_trademan.js"></script>
</head>

<body>
	<div class="grid-container"> <!-- beginning of main container div -->
		<div class="row column header"> <!-- beginning of top-of-page menu div -->
			<div class="top-bar">
				<div class="top-bar-left">
					<ul class="menu">
						<li class="menu-text"><a href="index.php"> Tradesman Finder</a></li>
					</ul>
				</div>
				<div class="top-bar-right">
					<ul class="menu">
						<li>
							<a href="find_trademan.php" id="find_trademan">
								<i class="fas fa-search"></i>
								Find Trademan
							</a>
						</li>

						<?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
							if ($_SESSION['user']['user_type_id'] == 1) { ?>
								<li><a href="view_users.php">Users</a></li>
								<li><a href="view_roles.php">User Types</a></li>
								<li><a href="trades_list.php">Trades</a></li>

							<?php }
							if ($_SESSION['user']['user_type_id'] == 2) { ?>

								<li><a href="add_tradesman_availability.php?id=<?= $_SESSION['user']['id'] ?>">Add Availablity</a></li>

							<?php } ?>

							<li><a href="view_profile.php?id=<?= $_SESSION['user']['id'] ?>">Profile</a></li>
							<li><a href="logout.php">Logout</a></li>

						<?php } else { ?>

							<li><a href="rate_trademan.php">Rate Trademan</a></li>
							<li><a href="register.php">Register</a></li>
							<li><a href="login.php">Login</a></li>
						<?php } ?>
						<li><a href="contact-us.php">Contact Us</a></li>
					</ul>
				</div>
			</div>
		</div> <!-- end of top-of-page menu div -->

		<!-- end of includes\header.html -->