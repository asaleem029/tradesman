<?php
include 'home.php';
include 'connect_db.php';
include 'classes/user.php';

$user = new User();
$user_detail = $user->getUser($db, $_GET['id']);

?>

<h3 class="center"><?= $user_detail['name']; ?></h3>

<div class="container">
	<div class="team-single">
		<div class="row">
			<div class="col-lg-3 col-md-4 xs-margin-30px-bottom">
			</div>

			<div class="col-lg-8 col-md-7">
				<div class="team-single-text padding-50px-left sm-no-padding-left">
					<div class="contact-info-section margin-40px-tb">
						<ul class="list-style9 no-margin">
							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left text-orange">ID:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['id'] ? $user_detail['id'] : '--' ?></p>
									</div>
								</div>

							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left text-yellow">Code:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p> <?= $user_detail['code'] ? $user_detail['code'] : '--' ?> </p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left text-lightred">Name:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['name'] ? $user_detail['name'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left text-green">Email:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['email'] ? $user_detail['email'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left xs-margin-four-left text-purple">Phone:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['phone'] ? $user_detail['phone'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left xs-margin-four-left text-pink">City:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['city'] ? $user_detail['city'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left xs-margin-four-left text-pink">Country:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['country'] ? $user_detail['country'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left xs-margin-four-left text-pink">Hourly Rate:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['hourly_rate'] ? $user_detail['hourly_rate'] : '--' ?></p>
									</div>
								</div>
							</li>

							<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
								<li>
									<div class="row">
										<div class="col-md-3 col-3">
											<strong class="margin-10px-left xs-margin-four-left text-pink">Status:</strong>
										</div>
										<div class="col-md-7 col-7">
											<p><?= $user_detail['status'] == 0 ? "Un-Block" : 'Block' ?></p>
										</div>
									</div>
								</li>
							<?php } ?>

							<?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
								<li>
									<div class="row">
										<div class="col-md-3 col-3">
											<strong class="margin-10px-left xs-margin-four-left text-pink">User Type:</strong>
										</div>
										<div class="col-md-7 col-7">
											<p><?= $user_detail['user_type_id'] == 1 ? "Admin" : 'Tradesman' ?></p>
										</div>
									</div>
								</li>
							<?php } ?>

							<li>
								<div class="row">
									<div class="col-md-3 col-3">
										<strong class="margin-10px-left xs-margin-four-left text-pink">Created At:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['created_at'] ? $user_detail['created_at'] : '--' ?></p>
									</div>
								</div>
							</li>

							<li>
								<div class="row" style="width: 82vw;">
									<div class="col-md-2 col-2">
										<strong class="margin-10px-left xs-margin-four-left text-pink">Summary:</strong>
									</div>
									<div class="col-md-7 col-7">
										<p><?= $user_detail['summary'] ? $user_detail['summary'] : '--' ?></p>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col back-button">
	<a href="view_users.php">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>
</div>

<?php include 'footer.php' ?>