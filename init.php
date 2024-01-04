<?php

ob_start();
session_start();

include_once 'connect_db.php';
include_once 'classes/login.php';
include_once 'classes/role.php';
include_once 'classes/user.php';
include_once 'classes/trade.php';
include_once 'classes/verify_otp.php';
include_once 'classes/reset_password.php';
include_once 'includes/helper.php';
