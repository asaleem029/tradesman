<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'VERIFY_OTP') {

    $verify_otp_obj = new VerifyOTP();
    $verify_otp_obj->verifyOTP($db, $_POST);
}
