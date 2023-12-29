<?php
include 'home.php';
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

<?php include 'footer.php' ?>