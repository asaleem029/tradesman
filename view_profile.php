<?php
include('home.php');
include 'connect_db.php';

if (!isset($_SESSION)) {
	session_start();
}

include 'classes/user.php';
include 'classes/trade.php';

$user = new User();
// USER DETAILS
$user_detail = $user->getUser($db, $_GET['id']);

// USER SKILLS
$user_skills = $user->getUserSkills($db, $_GET['id']);

// USER WORK HISTORY
$user_work_history = $user->getUserWorkHistory($db, $_GET['id']);
$work_images = explode(",", $user_work_history['images']);

// USER CERTIFICATIONS
$user_certifications = $user->getUserCertifications($db, $_GET['id']);
$certifications_images = explode(",", $user_certifications['images']);
?>
<link rel="stylesheet" href="css/complete_profile.css">


<!-- Display body section with sticky form. -->
<div class="container">
	<div class="form-signin">
		<div id="profile-form">
			<h3 class="form-signin-heading">Account Details</h3>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="id">ID</label>
						<input class="form-control" value="<?php if (isset($user_detail['id'])) echo $user_detail['id']; ?>" disabled>
					</div>

					<div class="col">
						<label for="code">Code</label>
						<input class="form-control" value="<?php if (isset($user_detail['code'])) echo $user_detail['code']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="name">Name</label>
						<input class="form-control" value="<?php if (isset($user_detail['name'])) echo $user_detail['name']; ?>" disabled>
					</div>

					<div class="col">
						<label for="email">Email</label>
						<input class="form-control" value="<?php if (isset($user_detail['email'])) echo $user_detail['email']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="user_type_id">Phone No.</label>
						<input class="form-control" value="<?php if (isset($user_detail['phone'])) echo $user_detail['phone']; ?>" disabled>
					</div>

					<div class="col">
						<label for="user_type_id">Trades</label>
						<input class="form-control" value="<?php if (isset($user_detail['trade_id'])) echo $user_detail['trade_id']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="city">Service City</label>
						<input class="form-control" value="<?php if (isset($user_detail['city'])) echo $user_detail['city']; ?>" disabled>
					</div>

					<div class="col">
						<label for="country">Service Country</label>
						<input class="form-control" value="<?php if (isset($user_detail['summary'])) echo $user_detail['summary']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="summary">Summary</label>
				<textarea class="form-control" disabled>
					<?php if (isset($user_detail['trade_id'])) echo $user_detail['trade_id']; ?>
				</textarea>
			</div>
		</div>

		<br>

		<div id="skills-form">
			<div class="row">
				<div class="col">
					<h3 class="form-signin-heading">Skills Details</h3>
				</div>
			</div>

			<div class="skills-div">
				<?php foreach ($user_skills as $skill) { ?>
					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for="id">Name</label>
								<input class="form-control" value="<?php if (isset($skill['name'])) echo $skill['name']; ?>" disabled>
							</div>

							<div class="col">
								<label for="code">Time Acquired</label>
								<input class="form-control" value="<?php if (isset($skill['time_acquired'])) echo $skill['time_acquired']; ?>" disabled>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<br>

		<div id="work-history-form">
			<h3 class="form-signin-heading">Work History Details</h3>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="work_type">Employement Type</label>
						<input class="form-control" value="<?php if (isset($user_work_history['work_type'])) echo $user_work_history['work_type']; ?>" disabled>
					</div>

					<div class="col">
						<label for="employer_name">Employer Name</label>
						<input class="form-control" value="<?php if (isset($user_work_history['employer_name'])) echo $user_work_history['employer_name']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="work_details">Work Details</label>
				<textarea class="form-control" disabled>
					<?php if (isset($user_work_history['work_details'])) echo $user_work_history['work_details']; ?>
			</textarea>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="field" align="left">
						<h3>Work Images</h3>
						<div style="display: flex;">
							<?php foreach ($work_images as $img) { ?>
								<div style="margin: 5px;">
									<img style="marign: 5px;" src="uploads/<?= $user_detail['id'] ?>/work_images/<?= $img ?>" width="200" height="200">
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>

		<div id="certification-form">
			<h3 class="form-signin-heading">Cerification Details</h3>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="certification_name">Name of Certification</label>
						<input class="form-control" value="<?php if (isset($user_certifications['certification_name'])) echo $user_certifications['certification_name']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="valid_till">Valid Till</label>
						<input class="form-control" value="<?php if (isset($user_certifications['valid_till'])) echo $user_certifications['valid_till']; ?>" disabled>
					</div>

					<div class="col">
						<label for="valid_from">Valid From</label>
						<input class="form-control" value="<?php if (isset($user_certifications['valid_from'])) echo $user_certifications['valid_from']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="field" align="left">
						<h3>Certificate's Images</h3>
						<div style="display: flex;">
							<?php foreach ($certifications_images as $img) { ?>
								<div style="margin: 5px;">
									<img style="marign: 5px;" src="uploads/<?= $user_detail['id'] ?>/certificates_images/<?= $img ?>" width="200" height="200">
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<br>

	<a href="home.php" class="btn btn-primary center" style="width:10%" >
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>

	<br>
	<br>
	<br>
</div>

<?php include('footer.php') ?>