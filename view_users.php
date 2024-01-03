<?php
include 'home.php';
include 'connect_db.php';
include 'classes/user.php';

if (!isset($_SESSION)) {
	session_start();
}

$users = array();
$user = new User();

if (isset($_POST['search']) && !empty($_POST['search'])) {
	$users = $user->getUsersList($db, $_POST['search']);
} else {
	$users = $user->getUsersList($db);
}
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

<form action="view_users.php" method="post">
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
				<input type="hidden" name="user_id" id="user_id" value="<?= $user['id'] ?>">
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
					<select id="user-status" class="form-select" name="status" aria-label="Default select example">
						<option <?= $user['status'] == 1 ? "selected=selected" : ""; ?> value="1">Un-Block</option>
						<option <?= $user['status'] == 2 ? "selected=selected" : ""; ?> value="2">Block</option>
					</select>
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
						<a href="delete_user.php?id=<?= $user['id']; ?>" class=<?= $_SESSION['user']['id'] == $user['id'] ? "disabled" : "" ?>>
							<i class="fas fa-trash"></i>
						</a>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$("#user-status").on("change", function(e) {
		e.preventDefault();

		$.ajax({
			url: "includes/user.php",
			type: "post",
			data: {
				action_type: "UPDATE_USER_STATUS",
				id: $("#user_id").val(),
				status: $("#user-status").val(),
			},
			success: function(d) {
				alert(d);
			}
		});
	})
</script>

<?php include 'footer.php' ?>