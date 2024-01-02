<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

class VerifyOTP
{
    function getOTP($id, $email, $mail_for)
    {
        require '../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'asaleem029@gmail.com';
            $mail->Password   = 'euykovwrlhaacfgf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('asaleem029@gmail.com', 'Tradesman Admin');
            $mail->addAddress($email);
            $mail->addReplyTo('info@tradesman.com', 'Tradesman');

            //generates random otp
            $otp = rand(100000, 999999);
            $_SESSION['session_otp'] = $otp;

            //Content
            $mail->Subject = 'Email Verification Code';
            $mail->Body    = 'Your one time email verification code is: ' . $otp;

            if ($mail->send()) {
                myAlert("OTP send to your email", '../verify_otp.php?id=' . $id . '&mail_for=' . $mail_for);
            }
        } catch (Exception $e) {
            return "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function verifyOTP($db, $data)
    {
        if ($data['otp'] == $_SESSION['session_otp']) {
            unset($_SESSION['session_otp']);

            $message = '';

            if ($data['mail_for'] == 'EMAIL_VERIFICATION') {
                $sql = "UPDATE `users` SET `email_verified` = 1 WHERE `id` = '{$data['id']}' ";

                if ($db->query($sql) === TRUE) {
                    $message = "Email Verified";
                } else {
                    $message = "Error updating record: " . $db->error;
                }
                
                myAlert($message, '../login.php');
            } else {
                include '../classes/reset_password.php';
                $reset_password_obj = new ResetPassword();
                $reset_password_obj->reset_password($db, $_SESSION['reset_password']);
            }
        }
    }
}
