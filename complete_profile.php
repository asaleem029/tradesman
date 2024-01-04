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

// GET USER INFORMATION
$user = new User();
$user_detail = $user->getUser($db, $_GET['id']);

// TRADES LIST
$trade = new Trade();
$trades_list = $trade->getTradesList($db);

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
	<form action="includes/user.php" method="post" class="form-signin" role="form" enctype="multipart/form-data">
		<input type="hidden" id="action_type" name="action_type" value="EDIT_PROFILE">

		<div id="profile-form">
			<h3 class="form-signin-heading">Complete Your Profile</h3>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="id">ID</label>
						<input class="form-control" type="text" name="id" size="20" value="<?php if (isset($user_detail['id'])) echo $user_detail['id']; ?>" readonly>
					</div>

					<div class="col">
						<label for="code">Code</label>
						<input class="form-control" type="text" name="code" size="50" value="<?php if (isset($user_detail['code'])) echo $user_detail['code']; ?>" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="name">Name</label>
						<input class="form-control" type="text" name="name" size="20" value="<?php if (isset($user_detail['name'])) echo $user_detail['name']; ?>" placeholder="Enter Name">
					</div>

					<div class="col">
						<label for="email">Email</label>
						<input class="form-control" type="email" name="email" size="50" value="<?php if (isset($user_detail['email'])) echo $user_detail['email']; ?>" placeholder="Enter Email Address" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="user_type_id">Phone No.</label>
						<input class="form-control" type="text" name="phone" size="50" value="<?php if (isset($user_detail['phone'])) echo $user_detail['phone']; ?>" placeholder="Enter Phone No.">
					</div>

					<div class="col">
						<label for="user_type_id">Trades</label>
						<select class="form-select" name="trade_id" aria-label="Default select example">
							<option>-- Select Trade --</option>
							<?php foreach ($trades_list as $trade) { ?>
								<option <?= $user_detail['trade_id'] == $trade['id'] ? 'selected="selected"' : ''  ?> value="<?= $trade['id'] ?>"><?= $trade['name'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="city">Service City</label>
						<input class="form-control" type="text" name="city" size="50" value="<?php if (isset($user_detail['city'])) echo $user_detail['city']; ?>" placeholder="Enter Service City">
					</div>

					<div class="col">
						<label for="country">Service Country</label>
						<input class="form-control" type="text" name="country" size="50" value="<?php if (isset($user_detail['country'])) echo $user_detail['country']; ?>" placeholder="Enter Service Country">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="hourly_rate">Hourly Rate</label>
						<input class="form-control" type="number" name="hourly_rate" size="50" value="<?php if (isset($user_detail['hourly_rate'])) echo $user_detail['hourly_rate']; ?>" placeholder="Enter Hourly Rate">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="summary">Summary</label>
				<textarea class="form-control" name="summary" id="summary" cols="30" rows="10" placeholder="Write Summary"><?= $user_detail['summary'] ?></textarea>
			</div>

			<br>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<button class="btn btn-primary" id="nextToSkillsForm">
							Next
							<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div id="skills-form">
			<div class="row">
				<div class="col">
					<h3 class="form-signin-heading">Skills</h3>
				</div>

				<div class="col">
					<button class="btn btn-primary" id="add_new_skill" style="float: right;">
						<i class="fa-solid fa-plus"></i>
					</button>
				</div>
			</div>

			<div class="skills-div">
				<?php foreach ($user_skills as $skill) { ?>
					<input type="hidden" name="skills[<?= $skill['id'] ?>][id]" value="<?= $skill['id'] ?>">
					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for="id">Name</label>
								<input class="form-control" name="skills[<?= $skill['id'] ?>][name]" value="<?php if (isset($skill['name'])) echo $skill['name']; ?>">
							</div>

							<div class="col">
								<label for="code">Time Acquired</label>
								<input class="form-control" name="skills[<?= $skill['id'] ?>][time_acquired]" value="<?php if (isset($skill['time_acquired'])) echo $skill['time_acquired']; ?>">
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<br>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<button class="btn btn-primary" id="backToProfileSection">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Back
						</button>
						<button class="btn btn-primary" id="nextToWorkHistoryForm">
							Next
							<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div>
		</div>

		<br>

		<div id="work-history-form">
			<h3 class="form-signin-heading">Work History</h3>

			<input type="hidden" name="work_id" value="<?= $user_work_history['id'] ?>">

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="work_type">Employement Type</label>
						<select class="form-select" name="work_type" aria-label="Default select example">
							<option>-- Please Select --</option>
							<option value="part_time" <?= isset($user_work_history['work_type']) && !empty($user_work_history['work_type']) == "part_time" ? "selected=selected" : "" ?>>Part Time</option>
							<option value="full_time" <?= isset($user_work_history['work_type']) && !empty($user_work_history['work_type']) == "full_time" ? "selected=selected" : "" ?>>Full Time</option>
						</select>
					</div>

					<div class="col">
						<label for="employer_name">Employer Name</label>
						<input type="text" name="employer_name" id="employer_name" placeholder="Enter Employer Name" value="<?php if (isset($user_work_history['employer_name'])) echo $user_work_history['employer_name']; ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="work_details">Work Details</label>
				<textarea class="form-control" name="work_details" id="work_details" cols="30" rows="10" placeholder="Write Work Details"><?php if (isset($user_work_history['work_details'])) echo $user_work_history['work_details']; ?></textarea>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="field" align="left">
						<h3>Upload Images</h3>
						<input type="file" id="work_images" name="work_images[]" multiple />
					</div>
				</div>
			</div>

			<br>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<button class="btn btn-primary" id="backToSkillsForm">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Back
						</button>
						<button class="btn btn-primary" id="nextToCertificationForm">
							Next
							<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div id="certification-form">
			<h3 class="form-signin-heading">Cerification</h3>
			<input type="hidden" name="certificate_id" value="<?= $user_certifications['id'] ?>">

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="certification_name">Name of Certification</label>
						<input type="text" name="certification_name" class="form-control" placeholder="Enter Certificate Name" value="<?php if (isset($user_certifications['certification_name'])) echo $user_certifications['certification_name']; ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="valid_till">Valid Till</label>
						<input type="date" class="form-control" name="valid_till" id="valid_till" value="<?php if (isset($user_certifications['valid_till'])) echo $user_certifications['valid_till']; ?>">
					</div>

					<div class="col">
						<label for="valid_from">Valid From</label>
						<input type="date" name="valid_from" id="valid_from" value="<?php if (isset($user_certifications['valid_from'])) echo $user_certifications['valid_from']; ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="field" align="left">
						<h3>Upload Images</h3>
						<input type="file" id="certificate_images" name="certificates_images[]" multiple />
					</div>
				</div>
			</div>

			<br>

			<div class="form-group">
				<div class="row">
					<div class="col">
						<button class="btn btn-primary" id="backToWorkHistoryForm">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Back
						</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	var user_skills =
		<?= count($user_skills) ?>
</script>
<script src="js/complete_profile.js"></script>

<?php include('footer.php') ?>