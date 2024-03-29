<?php
include 'header.php';
include 'connect_db.php';
include 'classes/user.php';
include 'classes/trade.php';

$user = new User();
$trade = new Trade();

// USER DETAILS
$user_detail = $user->getUser($db, $_GET['id']);

// GET TRADE NAME
$trade_info = $trade->getTrade($db, $user_detail['trade_id']);

// USER SKILLS
$user_skills = $user->getUserSkills($db, $_GET['id']);

// USER WORK HISTORY
$user_work_history = $user->getUserWorkHistory($db, $_GET['id']);

// USER CERTIFICATIONS
$user_certifications = $user->getUserCertifications($db, $_GET['id']);
?>
<link rel="stylesheet" href="css/complete_profile.css">

<!-- Display body section with sticky form. -->



<div class="container">
	<div class="form-signin">
		<?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
			<div class="form-group">
				<div class="row">
					<div class="col">
						<a href="index.php" class="btn btn-primary center" style="float:right; width:31%">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Back
						</a>
					</div>

					<div class="col">
						<a href="complete_profile.php?id=<?= $user_detail['id'] ?>" class="btn btn-primary center" style="width:50%">
							<i class="fas fa-edit" aria-hidden="true"></i>
							Edit Profile
						</a>
					</div>
				</div>
			</div>

			<br>
			<br>
		<?php } ?>

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
						<input class="form-control" value="<?php if (isset($trade_info['name'])) echo $trade_info['name']; ?>" disabled>
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
						<input class="form-control" value="<?php if (isset($user_detail['country'])) echo $user_detail['country']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="hourly_rate">Hourly Rate</label>
						<input class="form-control" value="<?php if (isset($user_detail['hourly_rate'])) echo $user_detail['hourly_rate']; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="summary">Summary</label>
				<textarea class="form-control" disabled>
					<?php if (isset($user_detail['summary'])) echo $user_detail['summary']; ?>
				</textarea>
			</div>
		</div>

		<br>
		
		<?php if (isset($user_skills) && !empty($user_skills)) { ?>
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
		<?php } ?>

		<br>

		<?php if (isset($user_work_history) && !empty($user_work_history)) { ?>
			<div id="work-history-form">
				<h3 class="form-signin-heading">Work History Details</h3>

				<?php foreach ($user_work_history as $his) { ?>
					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for="work_type">Employement Type</label>
								<input class="form-control" value="<?php if (isset($his['work_type'])) echo $his['work_type']; ?>" disabled>
							</div>

							<div class="col">
								<label for="employer_name">Employer Name</label>
								<input class="form-control" value="<?php if (isset($his['employer_name'])) echo $his['employer_name']; ?>" disabled>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="work_details">Work Details</label>
						<textarea class="form-control" disabled>
						<?php if (isset($his['work_details'])) echo $his['work_details']; ?>
					</textarea>
					</div>

					<?php if (isset($his['images']) && !empty($his['images'])) {
						$work_images = explode(",", $his['images']); ?>
						<div class="form-group">
							<div class="row">
								<div class="field" align="left">
									<h3>Work Images</h3>
									<div style="display: flex;">
										<?php foreach ($work_images as $img) { ?>
											<div style="margin: 5px;">
												<img style="marign: 5px;" src="uploads/<?= $user_detail['id'] ?>/work_images/<?= $his['id'] ?>/<?= $img ?>" width="200" height="200">
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<br>
				<?php } ?>
			</div>
		<?php } ?>

		<br>

		<?php if (isset($user_certifications) && !empty($user_certifications)) { ?>
			<div id="certification-form">
				<h3 class="form-signin-heading">Cerification Details</h3>

				<?php foreach ($user_certifications as $cert) { ?>
					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for="certification_name">Name of Certification</label>
								<input class="form-control" value="<?php if (isset($cert['certification_name'])) echo $cert['certification_name']; ?>" disabled>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for="valid_till">Valid Till</label>
								<input class="form-control" value="<?php if (isset($cert['valid_till'])) echo $cert['valid_till']; ?>" disabled>
							</div>

							<div class="col">
								<label for="valid_from">Valid From</label>
								<input class="form-control" value="<?php if (isset($cert['valid_from'])) echo $cert['valid_from']; ?>" disabled>
							</div>
						</div>
					</div>

					<?php if (isset($cert['images']) && !empty($cert['images'])) {
						$certifications_images = explode(",", $cert['images']);
					?>
						<div class="form-group">
							<div class="row">
								<div class="field" align="left">
									<h3>Certificate's Images</h3>
									<div style="display: flex;">
										<?php foreach ($certifications_images as $img) { ?>
											<div style="margin: 5px;">
												<img style="marign: 5px;" src="uploads/<?= $user_detail['id'] ?>/certificates_images/<?= $cert['id'] ?>/<?= $img ?>" width="200" height="200">
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<br>
				<?php } ?>
			</div>
		<?php } ?>
	</div>

	<br>
	<br>
	<br>
	<br>
	<br>
</div>

<?php include('footer.php') ?>