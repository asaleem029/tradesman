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
            $verify_otp_obj->getOTP($id, $data['email'], 'EMAIL_VERIFICATION');
        }

        return $result;
    }

    function  getUsersList($db, $search = '')
    {
        $where = '';
        if (isset($search) && !empty($search)) {
            $where = " WHERE `name` LIKE '%{$search}%' OR `code` LIKE '%{$search}%' OR `email` LIKE '%{$search}%' OR `phone` LIKE '%{$search}%' OR `city` LIKE '%{$search}%' OR `country` LIKE '%{$search}%' OR `hourly_rate` LIKE '%{$search}%' OR `summary` LIKE '%{$search}%'";
        }

        $query = "SELECT * FROM `users` $where";
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
        $sql1 = "UPDATE `users` SET `phone` = '{$data['phone']}', `trade_id` = '{$data['trade_id']}', `city` = '{$data['city']}', `country` = '{$data['country']}', `hourly_rate` = '{$data['hourly_rate']}', `summary` = '{$data['summary']}'  WHERE `id` = '{$_SESSION['user']['id']}'";

        // USER SKILLS SECTON
        foreach ($data['skills'] as $key => $skill) {
            $query1 = "INSERT INTO `user_skills` (`name`, `time_acquired`, `user_id`) 
            VALUES ('{$skill['name']}', '{$skill['skill_time']}', '{$_SESSION['user']['id']}')";
            $db->query($query1);
        }

        // USER WORK HOSTORY SECTION
        $work_images = implode(',', $_FILES['work_images']['name']);
        $this->uploadWorkImages($_FILES['work_images'], 'work_images');

        $query2 = "INSERT INTO `user_work_history` (`work_type`, `employer_name`, `work_details`, `user_id`, `images`) 
            VALUES ('{$data['work_type']}', '{$data['employer_name']}', '{$data['work_details']}', '{$_SESSION['user']['id']}', '{$work_images}')";
        $db->query($query2);

        // USER CERTIFICATES SECTON
        $certificates_images = implode(',', $_FILES['certificates_images']['name']);
        $this->uploadWorkImages($_FILES['certificates_images'], 'certificates_images');

        $query3 = "INSERT INTO `user_certifications` (`certification_name`, `valid_till`, `valid_from`, `user_id`, `images`) 
            VALUES ('{$data['certification_name']}', '{$data['valid_till']}', '{$data['valid_from']}', '{$_SESSION['user']['id']}', '{$certificates_images}')";
        $db->query($query3);

        if ($db->query($sql1) === TRUE) {
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

    function getUserSkills($db, $id)
    {
        $query = "SELECT * FROM `user_skills` WHERE `user_id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function getUserWorkHistory($db, $id)
    {
        $query = "SELECT * FROM `user_work_history` WHERE `user_id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function getUserCertifications($db, $id)
    {
        $query = "SELECT * FROM `user_certifications` WHERE `user_id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function uploadWorkImages($files, $type)
    {
        // Count # of uploaded files in array
        $total = count($files['name']);

        // Loop through each file
        for ($i = 0; $i < $total; $i++) {

            //Get the temp file path
            $tmpFilePath = $files['tmp_name'][$i];

            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newFilePath = "../uploads/" . $_SESSION['user']['id'] . "/" . $type . "/" . $files['name'][$i];

                if (!file_exists("../uploads/" . $_SESSION['user']['id'] . "/" . $type)) {
                    mkdir("../uploads/" . $_SESSION['user']['id'] . "/" . $type, 0777, true);
                }

                if (!file_exists($newFilePath)) {
                    //Upload the file into the temp dir
                    move_uploaded_file($tmpFilePath, $newFilePath);
                }
            }
        }
    }
}
