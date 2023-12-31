<?php

require('../connect_db.php');
include '../classes/verify_otp.php';
include '../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action'] == 'VERIFY_OTP') {

    $verify_otp_obj = new VerifyOTP();
    $verify_otp = $verify_otp_obj->verifyOTP($db, $_POST);
}
