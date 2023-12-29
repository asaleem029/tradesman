<?php
include('home_header.php');
include 'connect_db.php';
include 'classes/role.php';

$role = new Role();
$roles_list = $role->getRolesList($db);
?>

<!-- Display body section with sticky form. -->
<form action="includes/user.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Add New User</h3>
	<input type="hidden" id="action_type" name="action_type" value="ADD_NEW_USER">

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input class="form-control" type="text" name="name" size="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" placeholder="Enter Name">
			</div>

			<div class="col">
				<input class="form-control" type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Enter Email Address">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input class="form-control" type="text" name="phone" size="50" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" placeholder="Enter Phone No.">
			</div>

			<div class="col">
				<input class="form-control" type="text" name="hourly_rate" size="50" value="<?php if (isset($_POST['hourly_rate'])) echo $_POST['hourly_rate']; ?>" placeholder="Enter Hourly Rate">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input class="form-control" type="text" name="city" size="50" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>" placeholder="Enter City">
			</div>

			<div class="col">
				<input class="form-control" type="text" name="country" size="50" value="<?php if (isset($_POST['country'])) echo $_POST['country']; ?>" placeholder="Enter Country">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input class="form-control" type="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password">
			</div>

			<div class="col">
				<input class="form-control" type="password" name="c_password" size="20" value="<?php if (isset($_POST['c_password'])) echo $_POST['c_password']; ?>" placeholder="Confirm Password">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<select class="form-select" name="user_type_id" aria-label="Default select example">
					<option selected>-- Select User Type --</option>
					<?php foreach ($roles_list as $role) { ?>
						<option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col">
				<select class="form-select" name="status" aria-label="Default select example">
					<option selected>-- Select Status --</option>
					<option value="1">Block</option>
					<option value="2">Unblock</option>
				</select>
			</div>
		</div>
	</div>

	<br>

	<div class="form-group">
		<textarea class="form-control" name="summary" id="summary" cols="30" rows="10" placeholder="Write Summary"></textarea>
	</div>

	<br>

	<a class="btn btn-primary" href="view_users.php">Back</a>
	<button class="btn btn-primary" name="submit" type="submit">Register</button>
</form>

<?php include('footer.php') ?>