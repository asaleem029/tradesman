<?php include 'header.php'; ?>

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
			<small><a href="password.php">Reset Password?</a></small>
		</div>
		<div class="col">
			<button class="btn btn-primary" name="submit" type="submit">Login</button>
		</div>
	</div>
</form>

<?php include 'footer.php'; ?>