<?php
include('header.php');
include('includes/helper.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
?>

<div class="form">
	<h3>Contact Tradesman Finder</h3>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comments'])) {
			$mail = new PHPMailer(true);

			try {
				//Server settings
				$mail->isSMTP();
				$mail->Host       = 'smtp.gmail.com';
				$mail->SMTPAuth   = true;
				$mail->Username   = 'abdullah201897@gmail.com';
				$mail->Password   = 'fhycuklspjcxenxi';
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				$mail->Port       = 465;

				//Recipients
				$mail->setFrom($_POST['email'], $_POST['name']);
				$mail->addAddress('abdullah201897@gmail.com');

				//Content
				$mail->Subject = 'Contact Us Alert';
				$mail->Body = "Name: {$_POST['name']}\n\nComments: {$_POST['comments']}";

				if ($mail->send()) {
					myAlert("Thank you for contacting Tradesman Finder. We will respond to your enquiry in 48 hours", 'contact-us.php');
				}
			} catch (Exception $e) {
				return "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
			unset($_POST);
		} else {
			myAlert("Please fill out the form completely", 'contact-us.php');
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