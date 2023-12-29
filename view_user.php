<?php
include 'home.php';
include 'connect_db.php';
include 'classes/user.php';

$user = new User();
$user_detail = $user->getUser($db, $_GET['id']);
?>

<h3 class="center"><?= $user_detail['name']; ?></h3>
<div class="container user-detail">
	<div class="row">
		<div class="col"><b>ID </b></div>
		
		<div class="col"> <?= $user_detail['id'] ? $user_detail['id'] : '--'; ?> </div>
		<!-- <div class="col"><b>Name </b></div>
		<div class="col"><b>Email </b></div>
		<div class="col"><b>Phone no. </b></div>
		<div class="col"><b>City </b></div>
		<div class="col"><b>Country </b></div>
		<div class="col"><b>Hourly Rate </b></div>
		<div class="col"><b>User Type </b></div>
		<div class="col"><b>Status </b></div>
		<div class="col"><b>Created At </b></div>
		<div class="col"><b>Summary </b></div> -->
	</div>

	<div class="row">
		<!-- <div class="col"> <?= $user_detail['name'] ? $user_detail['name'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['email'] ? $user_detail['email'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['phone'] ? $user_detail['phone'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['city'] ? $user_detail['city'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['country'] ? $user_detail['country'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['hourly_rate'] ? $user_detail['hourly_rate'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['user_type_id'] ? $user_detail['user_type_id'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['status'] ? $user_detail['status'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['created_at'] ? $user_detail['created_at'] : '--'; ?> </div>
		<div class="col"> <?= $user_detail['summary'] ? $user_detail['summary'] : '--'; ?> </div> -->
	</div>
</div>
<div class="col back-button"> <a href="view_users.php"> <i class="fa fa-arrow-left" aria-hidden="true"></i>
Back</a> </div>

<?php include 'footer.php' ?>