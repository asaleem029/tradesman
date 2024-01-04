<?php

class Login
{
    function validate($db, $email = '', $pwd = '')
    {
        if (empty($email)) {
            $errors = 'Enter your email address.';
        } else {
            $e = $db->real_escape_string(trim($email));
        }

        if (empty($pwd)) {
            $errors = 'Enter your password.';
        } else {
            $p = $db->real_escape_string(trim($pwd));
        }

        if (empty($errors)) {
            $q = "SELECT * FROM `users` WHERE `email` = '$e' AND `password` = SHA1('$p')";
            $r = $db->query($q);

            if ($r->num_rows == 1) {
                $row = $r->fetch_array(MYSQLI_ASSOC);
                if ($row['email_verified'] == 1) {
                    return array(true, $row);
                } else {
                    $data['error'] = 'Email not verified';
                    $verify_otp_obj = new VerifyOTP();
                    $verify_otp_obj->getOTP($row['id'], $row['email'], 'EMAIL_VERIFICATION');
                }
            } else {
                $errors = 'Email and password not found';
                return array(false, $errors);
            }
        }
    }
}
