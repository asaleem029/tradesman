<?php include 'header.php' ?>

<form action="includes/verify_otp.php" method="post" class="form-signin" role="form">
    <input type="hidden" name="action" value="VERIFY_OTP">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" >

    <h3>Email Verification</h3>

    <div class="form-group">
        <label>OTP is sent to Your Email id</label>
    </div>

    <div class="form-group">
        <input class="form-control" type="number" name="otp" placeholder="Enter the OTP">
    </div>

    <button class="btn btn-primary" type="submit">Verify</button>
</form>

<?php include 'footer.php' ?>