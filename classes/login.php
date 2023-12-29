<?php

class Login
{
    function validate($db, $email = '', $pwd = '')
    {
        $errors = array();
        if (empty($email)) {
            $errors[] = 'Enter your email address. Fool.';
        } else {
            $e = $db->real_escape_string(trim($email));
        }

        if (empty($pwd)) {
            $errors[] = 'Enter your password. Fool.';
        } else {
            $p = $db->real_escape_string(trim($pwd));
        }

        if (empty($errors)) {
            $q = "SELECT `id`, `name`, `email` FROM `users` WHERE `email`='$e' AND `password`=SHA1('$p')";
            $r = $db->query($q);

            if ($r->num_rows == 1) {
                $row = $r->fetch_array(MYSQLI_ASSOC);
                return array(true, $row);
            } else {
                $errors[] = 'Email address and password not found.';
                return array(false, $errors);
            }
        }
    }
}
