<?php
include 'home.php';
include 'connect_db.php';
include 'classes/user.php';

$user = new User();
$users = $user->getUsersList($db);
?>

<div class="row">
	<div class="col">
		<h2>Users List</h2>
	</div>

	<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
		<div class="col inner-div-right">
			<a href="add_new_user.php" class="inline-anchor btn btn-primary">Add New User</a>
		</div>
	<?php } ?>
</div>

<table>
	<thead>
		<th>id</th>
		<th>Name</th>
		<th>Email</th>
		<th>Status</th>
		<th>View</th>
		<th>Edit</th>
		<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
			<th>Delete</th>
		<?php } ?>
	</thead>
	<tbody>
		<?php foreach ($users as $user) { ?>
			<tr>
				<td>
					<?= $user['id']; ?>
				</td>
				<td>
					<?= $user['name']; ?>
				</td>
				<td>
					<?= $user['email']; ?>
				</td>
				<td>
					<?= $user['status'] == 0 ? "Un-Block" : "Blocked"; ?>
				</td>
				<td>
					<a href="view_user.php?id=<?= $user['id']; ?>">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</a>
				</td>
				<td>
					<a href="edit_user.php?id=<?= $user['id']; ?>">
						<i class="fas fa-edit"></i>
					</a>
				</td>

				<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
					<td>
						<a href="delete_user.php?id=<?= $user['id']; ?>" class=<?= $_SESSION['id'] == $user['id'] ? "disabled" : "" ?>>
							<i class="fas fa-trash"></i>
						</a>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php include 'footer.php' ?>