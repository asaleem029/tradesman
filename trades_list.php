<?php
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['user']['id'])) {
	require('includes/helper.php');
	load();
}

include 'header.php';
include 'connect_db.php';
include 'classes/user.php';
include 'classes/trade.php';

$trades = array();
$trade = new Trade();

if (isset($_POST['search']) && !empty($_POST['search'])) {
	$trades = $trade->getTradesList($db, $_POST['search']);
} else {
	$trades = $trade->getTradesList($db);
}
?>

<div class="row">
	<div class="col">
		<h2>Trades List</h2>
	</div>

	<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
		<div class="col inner-div-right">
			<a href="add_new_trade.php" class="inline-anchor btn btn-primary">Add New Trade</a>
		</div>
	<?php } ?>
</div>

<form action="trades_list.php" method="post">
	<div class="row">
		<div class="col"></div>
		<div class="col">
			<div class="input-group search-bar">
				<input type="text" class="form-control" style="width: 50%;" name="search" placeholder="Search..." value="<?= isset($_POST['search']) && !empty($_POST['search']) ? $_POST['search'] : '' ?>">

				<div class="input-group-prepend">
					<button class="btn btn-primary" name="submit" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<table>
	<thead>
		<th>id</th>
		<th>Name</th>
		<th>Edit</th>
		<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
			<th>Delete</th>
		<?php } ?>
	</thead>
	<tbody>
		<?php foreach ($trades as $trade) { ?>
			<tr>
				<td>
					<?= $trade['id']; ?>
				</td>
				<td>
					<?= $trade['name']; ?>
				</td>
				<td>
					<a href="edit_trade.php?id=<?= $trade['id']; ?>">
						<i class="fas fa-edit"></i>
					</a>
				</td>

				<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
					<td>
						<a href="delete_trade.php?id=<?= $trade['id']; ?>">
							<i class="fas fa-trash"></i>
						</a>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php include 'footer.php' ?>