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
        $sql1 = "UPDATE `users` SET `name` = '{$data['name']}', `phone` = '{$data['phone']}', `trade_id` = '{$data['trade_id']}', `city` = '{$data['city']}', `country` = '{$data['country']}', `hourly_rate` = '{$data['hourly_rate']}', `summary` = '{$data['summary']}' WHERE `id` = '{$data['id']}'";

        // USER SKILLS SECTON STARTS
        if (isset($data['skills']) && !empty($data['skills'])) {
            foreach ($data['skills'] as $key => $skill) {

                if (isset($skill['id']) && !empty($skill['id'])) {
                    $user_skill = $this->getUserSkillById($db, $skill['id']);
                }

                if (isset($user_skill['id']) && !empty($user_skill['id'])) {

                    $sql2 = "UPDATE `user_skills` SET `name` = '{$skill['name']}', `time_acquired` = '{$skill['time_acquired']}', `user_id` = '{$data['id']}' WHERE `id` = '{$skill['id']}'";
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
        if (isset($data['work_history']) && !empty($data['work_history'])) {
            foreach ($data['work_history'] as $key => $work_history) {

                if (isset($work_history['work_id']) && !empty($work_history['work_id'])) {
                    $user_work_history = $this->getUserWorkHistoryById($db, $work_history['work_id']);
                }

                if (isset($user_work_history['id']) && !empty($user_work_history['id'])) {

                    $sql3 = "UPDATE `user_work_history` SET `work_type` = '{$work_history['work_type']}', `employer_name` = '{$work_history['employer_name']}', `work_details` = '{$work_history['work_details']}', `user_id` = '{$data['id']}' WHERE `id` = '{$user_work_history['id']}'";
                    $db->query($sql3);
                } else if (isset($work_history['work_type']) && isset($work_history['employer_name']) && isset($work_history['work_details']) && !empty($work_history['work_type']) && !empty($work_history['employer_name']) && !empty($work_history['work_details'])) {

                    $query2 = "INSERT INTO `user_work_history` (`work_type`, `employer_name`, `work_details`, `user_id`) 
                    VALUES ('{$work_history['work_type']}', '{$work_history['employer_name']}', '{$work_history['work_details']}', '{$data['id']}')";
                    $db->query($query2);
                }
            }
        }

        if (isset($_FILES['work_history']) && !empty($_FILES['work_history'])) {
            $work_images = array();
            $flag = false;

            foreach ($_FILES['work_history']['name'] as $key => $image) {
                if (!array_key_exists($key, $work_images)) {
                    $work_images[$key]['images'] = implode(',', $image['work_images']);
                    $flag = true;
                }
            }

            $this->uploadWorkImages($_FILES['work_history'], 'work_images', $data['id']);

            if ($flag) {
                foreach ($work_images as $key => $image) {
                    $sql3 = "UPDATE `user_work_history` SET `images` = '{$image['images']}' WHERE `id` = '{$key}'";
                    $db->query($sql3);
                }
            }
        }
        // USER WORK HOSTORY SECTION ENDS

        // USER CERTIFICATES SECTON STARTS
        if (isset($data['certifications']) && !empty($data['certifications'])) {
            foreach ($data['certifications'] as $cert) {

                if (isset($cert['certificate_id']) && !empty($cert['certificate_id'])) {
                    $user_certification = $this->getUserCertificationsById($db, $cert['certificate_id']);
                }

                if (isset($user_certification['id']) && !empty($user_certification['id']) && $user_certification['id'] == $cert['certificate_id']) {

                    $sql4 = "UPDATE `user_certifications` SET `certification_name` = '{$cert['certification_name']}', `valid_till` = '{$cert['valid_till']}', `valid_from` = '{$cert['valid_from']}', `user_id` = '{$data['id']}' WHERE `id` = '{$user_certification['id']}'";
                    $db->query($sql4);
                } else {

                    $query3 = "INSERT INTO `user_certifications` (`certification_name`, `valid_till`, `valid_from`, `user_id`) 
                    VALUES ('{$cert['certification_name']}', '{$cert['valid_till']}', '{$cert['valid_from']}', '{$data['id']}')";
                    $db->query($query3);
                }
            }
        }

        if (isset($_FILES['certifications']) && !empty($_FILES['certifications'])) {
            $certificates_images = array();

            foreach ($_FILES['certifications']['name'] as $key => $image) {
                if (!array_key_exists($key, $certificates_images)) {
                    $certificates_images[$key]['images'] = implode(',', $image['certificates_images']);
                }
            }

            $this->uploadWorkImages($_FILES['certifications'], 'certificates_images', $data['id']);

            foreach ($certificates_images as $key => $image) {
                $sql3 = "UPDATE `user_certifications` SET `images` = '{$image['images']}' WHERE `id` = '{$key}'";
                $db->query($sql3);
            }
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
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function getUserCertifications($db, $id)
    {
        $query = "SELECT * FROM `user_certifications` WHERE `user_id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function getUserCertificationsById($db, $id)
    {
        $query = "SELECT * FROM `user_certifications` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }

    function uploadWorkImages($files, $type, $user_id)
    {
        // Loop through each file
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            foreach ($tmp_name[$type] as $key1 => $img) {
                //Get the temp file path
                $tmpFilePath = $img;
                $file_name = $files['name'][$key][$type][$key1];

                //Make sure we have a file path
                if ($tmpFilePath != "") {
                    //Setup our new file path
                    $newFilePath = "../uploads/" . $user_id . "/" . $type . "/" . $key . "/" . $file_name;

                    if (!file_exists("../uploads/" . $user_id . "/" . $type . "/" . $key)) {
                        mkdir("../uploads/" . $user_id . "/" . $type . "/" . $key, 0777, true);
                    }

                    if (!file_exists($newFilePath)) {
                        //Upload the file into the temp dir
                        move_uploaded_file($tmpFilePath, $newFilePath);
                    }
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

    function addAvailability($db, $data)
    {
        $sql = "UPDATE `users` SET `available_from` = '{$data['available_from']}', `available_to` = '{$data['available_to']}' WHERE `id` = '{$data['id']}'";

        if ($db->query($sql) === TRUE) {
            return "Availability Updated";
        } else {
            return "Error updating record: " . $db->error;
        }
    }

    function getTradesman($db, $data)
    {
        $where = '';

        if (!empty($data['city']) && empty($data['trade_id'])) {
            $where = "WHERE `u`.`city` = '{$data['city']}' ";
        } else if (!empty($data['trade_id']) && empty($data['city'])) {
            $where = "WHERE `u`.`trade_id` = '{$data['trade_id']}' ";
        } else if (!empty($data['trade_id']) && !empty($data['city'])) {
            $where = "WHERE `u`.`city` = '{$data['city']}' AND `u`.`trade_id` = '{$data['trade_id']}' ";
        }

        $array = array();

        $sql = "SELECT `u`.`id`, `u`.`name`, `u`.`phone`, `u`.`trade_id`, `u`.`hourly_rate`, FORMAT(IFNULL(`u`.`rating` / `u`.`rating_count`, 0), 2) AS `trademan_rating`, `available_to`,`available_from`, COUNT(`uc`.`user_id`) AS `certificate_count`
        FROM `users` AS `u`
        INNER JOIN `user_certifications` AS `uc` ON (`u`.`id` = `uc`.`user_id`) 
        $where
        GROUP BY `uc`.`user_id`
        ORDER BY `certificate_count` DESC";

        $response = $db->query($sql);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        if (isset($data['date']) && !empty($data['date'])) {
            foreach ($result as $res) {
                if ($res['available_to'] >= $data['date'] && $res['available_from'] <= $data['date']) {
                    array_push($array, $res);
                }
            }
        } else {
            $array = $result;
        }

        return $array;
    }
}
