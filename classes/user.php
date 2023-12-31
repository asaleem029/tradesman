<?php
class User
{
    function checkEmail($db, $email)
    {
        $query = "SELECT `id` FROM `users` WHERE `email`='{$email}'";
        $result = $db->query($query);

        return $result->num_rows;
    }

    function getUserEmail($db, $id)
    {
        $query = "SELECT `email` FROM `users` WHERE `id`='{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result['email'];
    }

    function registerNewUser($db, $data)
    {
        $users_count = $this->getUsersCount($db);
        $users_type_id = 2;

        if ($users_count == 0) {
            $users_type_id = 1;
        }

        $query = "INSERT INTO `users` (`name`, `code`, `email`, `user_type_id`, `password`, `created_at`) 
              VALUES ('{$data['name']}', '{$this->random_digits(10)}', '{$data['email']}', '{$users_type_id}', SHA1('{$data['password']}'), NOW() )";
        $result = $db->query($query);
        $id = $db->insert_id;

        if ($result) {
            include 'verify_otp.php';

            $verify_otp_obj = new VerifyOTP();
            $verify_otp_obj->getOTP($id, $data['email']);
        }

        return $result;
    }

    function  getUsersList($db)
    {
        $query = "SELECT * FROM `users`";
        $response = $db->query($query);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function  getUser($db, $id)
    {
        $query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function deleteUser($db, $id)
    {
        $sql = "DELETE FROM `users` WHERE `id` = '{$id}'";

        if (mysqli_query($db, $sql)) {
            return "User Deleted Successfully";
        }
    }

    function random_digits($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= random_int(0, 9);
        }

        return $result;
    }

    function addNewUser($db, $data)
    {
        $query = "INSERT INTO `users` (`name`, `code`, `email`, `phone`, `hourly_rate`, `city`, `country`, `user_type_id`, `status`, `password`, `created_at`) 
              VALUES ('{$data['name']}', '{$this->random_digits(10)}', '{$data['email']}','{$data['phone']}', '{$data['hourly_rate']}', '{$data['city']}', '{$data['country']}', '{$data['user_type_id']}', '{$data['status']}', SHA1('{$data['password']}'), NOW() )";
        $result = $db->query($query);

        return $result;
    }

    function updateUserDetails($db, $data)
    {
        $sql = "UPDATE `users` SET `name` = '{$data['name']}', `email` = '{$data['email']}', `hourly_rate` = '{$data['hourly_rate']}', `phone` = '{$data['phone']}', `city` = '{$data['city']}', `country` = '{$data['country']}', `user_type_id` = '{$data['user_type_id']}', `status` = '{$data['status']}', `summary` = '{$data['summary']}'  WHERE `id` = '{$data['id']}'";

        if ($db->query($sql) === TRUE) {
            return "User updated successfully";
        } else {
            return "Error updating record: " . $db->error;
        }
    }

    function updateProfile($db, $data)
    {
        $sql = "UPDATE `users` SET `hourly_rate` = '{$data['hourly_rate']}', `phone` = '{$data['phone']}', `city` = '{$data['city']}', `country` = '{$data['country']}', `summary` = '{$data['summary']}'  WHERE `id` = '{$_SESSION['user']['id']}'";

        if ($db->query($sql) === TRUE) {
            return "Profile Updated Successfully";
        } else {
            return "Error updating record: " . $db->error;
        }
    }

    function getUsersCount($db)
    {
        $query = "SELECT * FROM `users`";
        $response = $db->query($query);

        return $response->num_rows;
    }
}
