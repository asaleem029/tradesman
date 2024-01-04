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

    function getUser($db, $id)
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
        $sql1 = "UPDATE `users` SET `name` = '{$data['name']}', `phone` = '{$data['phone']}', `trade_id` = '{$data['trade_id']}', `city` = '{$data['city']}', `country` = '{$data['country']}', `hourly_rate` = '{$data['hourly_rate']}', `summary` = '{$data['summary']}'  WHERE `id` = '{$data['id']}'";

        // USER SKILLS SECTON STARTS
        if (isset($data['skills']) && !empty($data['skills'])) {
            foreach ($data['skills'] as $key => $skill) {

                if (isset($skill['id']) && !empty($skill['id'])) {
                    $user_skill = $this->getUserSkillById($db, $skill['id']);
                }

                if (isset($user_skill['id']) && !empty($user_skill['id'])) {

                    $sql2 = "UPDATE `user_skills` SET `name` = '{$skill['name']}', `time_acquired` = '{$skill['time_acquired']}' WHERE `id` = '{$skill['id']}'";
                    $db->query($sql2);
                } else if (isset($skill['name']) && !empty($skill['name']) && isset($skill['skill_time']) && !empty($skill['skill_time'])) {

                    $query1 = "INSERT INTO `user_skills` (`name`, `time_acquired`, `user_id`) 
                    VALUES ('{$skill['name']}', '{$skill['skill_time']}', '{$data['id']}')";
                    $db->query($query1);
                }
            }
        }
        // USER SKILLS SECTON ENDS

        // USER WORK HOSTORY SECTION STARTS
        if (isset($_FILES['work_images']) && !empty($_FILES['work_images'])) {
            $work_images = implode(',', $_FILES['work_images']['name']);
            $this->uploadWorkImages($_FILES['work_images'], 'work_images');
        }

        $user_work_history = $this->getUserWorkHistoryById($db, $data['work_id']);

        if (isset($user_work_history) && !empty($user_work_history)) {

            $sql3 = "UPDATE `user_work_history` SET `work_type` = '{$data['work_type']}', `employer_name` = '{$data['employer_name']}', `work_details` = '{$data['work_details']}', `user_id` = '{$data['id']}', `images` = '{$work_images}' WHERE `id` = '{$data['work_id']}'";
            $db->query($sql3);
        } else if (isset($data['work_type']) && isset($data['employer_name']) && isset($data['work_details']) && !empty($data['work_type']) && !empty($data['employer_name']) && !empty($data['work_details'])) {

            $query2 = "INSERT INTO `user_work_history` (`work_type`, `employer_name`, `work_details`, `user_id`, `images`) 
            VALUES ('{$data['work_type']}', '{$data['employer_name']}', '{$data['work_details']}', '{$_SESSION['user']['id']}', '{$work_images}')";
            $db->query($query2);
        }
        // USER WORK HOSTORY SECTION ENDS

        // USER CERTIFICATES SECTON STARTS
        $certificates_images = implode(',', $_FILES['certificates_images']['name']);
        $this->uploadWorkImages($_FILES['certificates_images'], 'certificates_images');

        $user_certification = $this->getUserCertificationsById($db, $data['certificate_id']);

        if (isset($user_certification) && !empty($user_certification)) {

            $sql4 = "UPDATE `user_certifications` SET `certification_name` = '{$data['certification_name']}', `valid_till` = '{$data['valid_till']}', `valid_from` = '{$data['valid_from']}', `user_id` = '{$data['id']}', `images` = '{$certificates_images}' WHERE `id` = '{$data['certificate_id']}'";
            $db->query($sql4);
        } else if (isset($data['certification_name']) && isset($data['valid_till']) && isset($data['valid_from']) && !empty($data['certification_name']) && !empty($data['valid_till']) && !empty($data['valid_from'])) {

            $query3 = "INSERT INTO `user_certifications` (`certification_name`, `valid_till`, `valid_from`, `user_id`, `images`) 
                VALUES ('{$data['certification_name']}', '{$data['valid_till']}', '{$data['valid_from']}', '{$data['id']}', '{$certificates_images}')";
            $db->query($query3);
        }
        // USER CERTIFICATES SECTON ENDS

        if ($db->query($sql1) === TRUE) {
            return "Profile Updated Successfully";
        } else {
            return "Error updating record: " . $db->error;
        }
    }

    function updateUserStatus($db, $data)
    {
        $sql = "UPDATE `users` SET `status` = '{$data['status']}'  WHERE `id` = '{$data['id']}'";

        if ($db->query($sql) === TRUE) {
            return "Status Updated Successfully";
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

    function getUserSkillById($db, $id)
    {
        $query = "SELECT * FROM `user_skills` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function getUserWorkHistoryById($db, $id)
    {
        $query = "SELECT * FROM `user_work_history` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

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

    function getUserCertificationsById($db, $id)
    {
        $query = "SELECT * FROM `user_certifications` WHERE `id` = '{$id}'";
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

    function getUserByCode($db, $code)
    {
        $query = "SELECT `code` FROM `users` WHERE `code` = '{$code}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function addRating($db, $data)
    {
        $user = $this->getUserByCode($db, $data['code']);

        if (isset($user) && !empty($user)) {

            $sql = "UPDATE `users` SET `rating` = `rating` +  '{$data['rate']}', `rating_count` = `rating_count` +  1 WHERE `code` = '{$data['code']}'";

            if ($db->query($sql) === TRUE) {
                return "Rating Submitted";
            } else {
                return "Error updating record: " . $db->error;
            }
        } else {
            return "Trademan Not Found";
        }
    }

    function getTradesman($db, $data)
    {
        $sql = "SELECT `id`, `name`, `phone`, `trade_id`, `hourly_rate`, FORMAT(`rating` / `rating_count`, 2) AS `trademan_rating`
        FROM `users` 
        WHERE (`rating` != 0 AND `rating_count` != 0) 
        AND (`city` = '{$data['city']}' 
        OR `trade_id` = '{$data['trade_id']}')
        ORDER BY `trademan_rating` DESC";

        $response = $db->query($sql);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }
}
