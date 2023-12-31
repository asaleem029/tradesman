<?php include('header.php'); ?>

<div class="container">
	<div class="row">
		<div class="span6">
			<form action="includes/reset_password.php" method="post" class="form-signin" role="form">
				<h1 class="form-signin-heading">Reset Your Password</h1>

				<input type="hidden" name="action_type" value="RESET_PASSWORD">

				<div class="form-group">
					<input class="form-control" type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email address" />
				</div>

				<div class="form-group">
					<input class="form-control" type="password" name="new_password" size="10" maxlength="20" value="<?php if (isset($_POST['new_password'])) echo $_POST['new_password']; ?>" placeholder="New Password" />
				</div>

				<div class="form-group">
					<input class="form-control" type="password" name="c_password" size="10" maxlength="20" value="<?php if (isset($_POST['c_password'])) echo $_POST['c_password']; ?>" placeholder="Confirm New Password" />
				</div>

				<button class="btn btn-primary" name="submit" type="submit">Reset Password</button>
			</form>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>