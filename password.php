<?php 
include ('header.php');
?>


<div class="container">
	<div class="row">
		<div class="span3">
		</div>
		<div class="span6">
			
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//Use function require_once to add file to connect to database

	$errors = array();

	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = $dbc->real_escape_string(trim($_POST['email']));
	}

	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = $dbc->real_escape_string(trim($_POST['pass']));
	}

	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = $dbc->real_escape_string(trim($_POST['pass1']));
		}

	} else {
		$errors[] = 'You forgot to enter your new password.';
	}

	if (empty($errors)) { 
		$q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA1('$p') )";
		$r = $dbc->query($q);
		$num = $r->num_rows;
		if ($num == 1) { 
			// using fetch_array() with MYSQLI_NUM formats the result set as a normal array.
			$row = $r->fetch_array(MYSQLI_NUM);
			$q = "UPDATE users SET pass=SHA1('$np') WHERE user_id=$row[0]";		
			$r = $dbc->query($q);

			if ($dbc->affected_rows == 1) { // If it ran OK.
				echo '<h1>Thank you!</h1>
					<p>Your password has been updated. Now you can login</p><br />';	
			} else { 
				echo '<h1>System Error</h1>
					<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
				echo '<p>' . $dbc->error . '<br /><br />Query: ' . $q . '</p>';
			}

			$dbc->close(); 
		
			include ('footer.php'); 
			exit();

		} else { 
			echo '<h1>Error!</h1>
				<p class="error">The email address and password do not match those on file.</p>';
		}

	} else { 

		echo '<h1>Error!</h1>
			<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { 
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><br />';
	} 

	$dbc->close(); 

} 
?>

			<h1>Reset Your Password</h1>
			<form action="password.php" method="post" class="form-signin" role="form">
				<input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email address" />
				<input type="password" name="pass" size="10" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" placeholder="Current Password" />
				<input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" placeholder="New Password" />
				<input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" placeholder="Confirm New Password"  />
				<p><button class="btn btn-primary" name="submit" type="submit">Reset Password</button></p>
			</form>
		</div>
		<div class="span3">
		</div>
	</div>
</div>

<hr>

<?php include ('footer.php'); ?>