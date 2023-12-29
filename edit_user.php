<?php

include 'home.php';
include 'connect_db.php';
include 'classes/user.php';
include 'classes/role.php';

$user = new User();
$user_detail = $user->getUser($db, $_GET['id']);

$role = new Role();
$roles_list = $role->getRolesList($db);
$role_name = $role->getRoleName($db, $user_detail['user_type_id']);
?>

<!-- Display body section with sticky form. -->
<form action="includes/user.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Update User Details</h3>
	<input type="hidden" id="action_type" name="action_type" value="UPDATE_USER_DETAILS">

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="id">ID</label>
				<input class="form-control" type="text" name="id" size="20" value="<?php if (isset($user_detail['id'])) echo $user_detail['id']; ?>" readonly>
			</div>

			<div class="col">
				<label for="code">Code</label>
				<input class="form-control" type="text" name="code" size="50" value="<?php if (isset($user_detail['code'])) echo $user_detail['code']; ?>" readonly>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="name">Name</label>
				<input class="form-control" type="text" name="name" size="20" value="<?php if (isset($user_detail['name'])) echo $user_detail['name']; ?>" placeholder="Enter Name">
			</div>

			<div class="col">
				<label for="email">Email</label>
				<input class="form-control" type="email" name="email" size="50" value="<?php if (isset($user_detail['email'])) echo $user_detail['email']; ?>" placeholder="Enter Email Address">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="hourly_rate">Hourly Rate</label>
				<input class="form-control" type="text" name="hourly_rate" size="50" value="<?php if (isset($user_detail['hourly_rate'])) echo $user_detail['hourly_rate']; ?>" placeholder="Enter Hourly Rate">
			</div>

			<div class="col">
				<label for="phone">Phone No.</label>
				<input class="form-control" type="text" name="phone" size="50" value="<?php if (isset($user_detail['phone'])) echo $user_detail['phone']; ?>" placeholder="Enter Phone No.">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="city">City</label>
				<input class="form-control" type="text" name="city" size="50" value="<?php if (isset($user_detail['city'])) echo $user_detail['city']; ?>" placeholder="Enter City">
			</div>

			<div class="col">
				<label for="country">Country</label>
				<input class="form-control" type="text" name="country" size="50" value="<?php if (isset($user_detail['country'])) echo $user_detail['country']; ?>" placeholder="Enter Country">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="user_type_id">User Type</label>
				<select class="form-select" name="user_type_id" aria-label="Default select example">
					<option>-- Select User Type --</option>
					<?php foreach ($roles_list as $role) { ?>
						<option <?= $user_detail['user_type_id'] == $role['id'] ? 'selected="selected"' : ''  ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col">
				<label for="status">Status</label>
				<select class="form-select" name="status" aria-label="Default select example">
					<option>-- Select Status --</option>
					<option <?= $user_detail['status'] == 1 ? 'selected="selected"' : '' ?> value="1">Block</option>
					<option <?= $user_detail['status'] == 2 ? 'selected="selected"' : '' ?> value="2">Unblock</option>
				</select>
			</div>
		</div>
	</div>

	<br>

	<div class="form-group">
		<label for="summary">Summary</label>
		<textarea class="form-control" name="summary" id="summary" cols="30" rows="10" placeholder="Write Summary">
		<?= $user_detail['summary'] ? $user_detail['summary'] : '' ?>
		</textarea>
	</div>

	<br>

	<a class="btn btn-primary" href="view_users.php">Back</a>
	<button class="btn btn-primary" name="submit" type="submit">Update</button>
</form>

<?php include('footer.php') ?>