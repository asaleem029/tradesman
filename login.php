<?php 
include 'header.php';

if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) {
    header("Location: index.php");
}
?>

<!-- Display login form -->
<form action="includes/login.php" method="post" class="form-signin" role="form">
	<h2 class="form-signin-heading">Please login</h2>
	<input type="hidden" id="action_type" name="action_type" value="LOGIN">

	<div class="form-group">
		<input type="text" class="form-control" name="email" placeholder="Email Address">
	</div>

	<div class="form-group">
		<input type="password" class="form-control" name="pass" placeholder="Password">
	</div>

	<div class="form-group">
		<div class="col">
			<small><a href="reset_password.php">Forgot Password?</a></small>
		</div>
		<br>
		<div class="col">
			<button class="btn btn-primary" name="submit" type="submit">Login</button>
		</div>
	</div>
</form>

<?php include 'footer.php'; ?>