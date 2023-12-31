<?php include('header.php'); ?>

<!-- Display body section with sticky form. -->
<form action="includes/register.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Create New Account</h3>
	<input type="hidden" id="action_type" name="action_type" value="REGISTER_NEW_USER">

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input type="text" name="name" size="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" placeholder="Enter Name">
			</div>

			<div class="col">
				<input type="email" name="email" size="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Enter Email Address">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input type="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password">
			</div>

			<div class="col">
				<input type="password" name="c_password" size="20" value="<?php if (isset($_POST['c_password'])) echo $_POST['c_password']; ?>" placeholder="Confirm Password">
			</div>
		</div>
	</div>

	<button class="btn btn-primary" name="submit" type="submit">Register</button>
</form>

<?php include('footer.php') ?>