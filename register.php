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

	<!-- <div class="form-group">
		<div class="row">
			<div class="col">
				<input type="text" name="code" size="50" value="<?php if (isset($_POST['code'])) echo $_POST['code']; ?>" placeholder="Enter Code">
			</div>

			<div class="col">
				<input type="text" name="phone" size="50" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" placeholder="Enter Phone No.">
			</div>
		</div>
	</div> -->

<!-- 
	<div class="form-group">
		<div class="row">
			<div class="col">
				<input type="text" name="city" size="50" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>" placeholder="Enter City">
			</div>

			<div class="col">
				<input type="text" name="country" size="50" value="<?php if (isset($_POST['country'])) echo $_POST['country']; ?>" placeholder="Enter Country">
			</div>
		</div>
	</div>

	<div class="form-group">
		<input type="text" name="hourly_rate" size="50" value="<?php if (isset($_POST['hourly_rate'])) echo $_POST['hourly_rate']; ?>" placeholder="Enter Hourly Rate">
	</div> -->

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
<!-- 
	<div class="form-group">
		<textarea name="summary" id="summary" cols="30" rows="10" placeholder="Write Summary"></textarea>
	</div> -->

	<button class="btn btn-primary" name="submit" type="submit">Register</button>
</form>

<?php include('footer.php') ?>