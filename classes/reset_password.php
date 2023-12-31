<?php

class ResetPassword
{
    function reset_password($db, $data)
    {
        $sql = "UPDATE `users` SET `password` = SHA1('{$data['new_password']}') WHERE `email`= '{$data['email']}'";

        if ($db->query($sql) === TRUE) {
            myAlert("Password Updated Successfully", '../login.php');
        } else {
            myAlert($db->error, '../reset_password.php');
        }
    }
}
