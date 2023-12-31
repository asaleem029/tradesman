<?php
include('home_header.php');
include 'connect_db.php';
?>

<!-- Display body section with sticky form. -->
<form action="includes/user.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Complete Your Profile</h3>
	<input type="hidden" id="action_type" name="action_type" value="UPDATE_PROFILE">

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
		<textarea class="form-control" name="summary" id="summary" cols="30" rows="10" placeholder="Write Summary"></textarea>
	</div>

	<br>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<a class="btn btn-primary" style="float:right;" href="index.php">Skip</a>
			</div>

			<div class="col">
				<button class="btn btn-primary" name="submit" type="submit">Update</button>
			</div>
		</div>
	</div>

</form>

<?php include('footer.php') ?>