<?php
session_start();
if (isset($_SESSION['user_id'])) { 		// if the SESSION 'user_id' is  set...
	include('includes/home_header.php');
} else {
	include('header.php');
}
?>

<div class="form">
	<h3>Contact Innovation Centre</h3>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		error_reporting(0);
		if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comments'])) {
			$body = "Name: {$_POST['name']}\n\nComments: {$_POST['comments']}";
			$body = wordwrap($body, 70);
			mail('c3043125@shu.ac.uk', 'Contact Form Submission', $body, "From: {$_POST['email']}");
			echo '<p><em>Thank you for contacting Innovation Centre. We will respond to your enquiry in 48 hours.</em></p>';
			$_POST = array();
		} else {
			echo 	'<p style="font-weight: bold; color: red">
						Please fill out the form completely.
					</p>';
		}
	}
	?>

	<p>Please fill out this form to contact Innovation Centre.</p>
	<form action="contact-us.php" method="post" class="form-signin" role="form">
		<table width="60%">
			<tr>
				<td>Name: </td>
				<td><input type="text" name="name" size="30" maxlength="60" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></td>
			</tr>
			<tr>
				<td>Email Address: </td>
				<td><input type="text" name="email" size="30" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td>
			</tr>
			<tr>
				<td>Enquiry: </td>
				<td><textarea name="comments" rows="5" cols="30"><?php if (isset($_POST['comments'])) echo $_POST['comments']; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
</div>

<?php include('footer.php') ?>