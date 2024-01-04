<?php
include 'header.php';

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['user']['id'])) {
	require('includes/helper.php');
	load();
}

include 'connect_db.php';
include 'classes/role.php';

$role = new Role();
$roles = $role->getRolesList($db);
?>

<h3 class="center">User Types List</h3>
<table class="center">
	<thead>
		<th>id</th>
		<th>Type Name</th>
		<th>Created At</th>
	</thead>
	<tbody>
		<?php foreach ($roles as $role) { ?>
			<tr>
				<td>
					<?= $role['id']; ?>
				</td>
				<td>
					<?= $role['name']; ?>
				</td>
				<td>
					<?= $role['created_at']; ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<div class="center">
	<a href="view_users.php" class="btn btn-primary">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>
</div>

<?php include 'footer.php' ?>