<?php
include 'header.php';

if (!isset($_SESSION['user']['id'])) {
	require('includes/helper.php');
	load();
}

?>

<!-- Display body section with sticky form. -->
<form action="includes/trade.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Add New Trade</h3>
	<input type="hidden" id="action_type" name="action_type" value="ADD_NEW_TRADE">

	<div class="form-group">
		<div class="row">
			<div class="col">
				<input class="form-control" type="text" name="name" size="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" placeholder="Enter Name">
			</div>
		</div>
	</div>

	<a class="btn btn-primary" href="trades_list.php">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>
	<button class="btn btn-primary" name="submit" type="submit">Save</button>
</form>

<?php include('footer.php') ?>