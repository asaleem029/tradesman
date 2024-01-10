<?php
include 'header.php';

if (!isset($_SESSION['user']['id'])) {
	require('includes/helper.php');
	load();
}
?>

<!-- Display body section with sticky form. -->
<form action="includes/user.php" method="post" class="form-signin" role="form">
	<input type="hidden" name="action_type" value="ADD_AVAILABILITY">
	<input type="hidden" name="id" value="<?= $_GET['id'] ?>">

	<h3 class="form-signin-heading">Add Availablity</h3>

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="available_from">Available From</label>
				<input type="date" name="available_from" id="available_from">
			</div>

			<div class="col">
				<label for="available_to">Available To</label>
				<input type="date" name="available_to" id="available_to">
			</div>
		</div>
	</div>

	<a class="btn btn-primary" href="index.php">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>
	<button class="btn btn-primary" name="submit" type="submit">Submit</button>
</form>

<?php include('footer.php') ?>