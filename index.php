<?php include 'header.php'; ?>

<div class="container">

    <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
        <h3>Welcome <b><?= strtoupper($_SESSION['user']['name']) ?></b> To Tradesman Finder</h3>
    <?php } else { ?>
        <h3>Welcome To Tradesman Finder</h3>
    <?php } ?>
    <img src="img/innovation.jpg" />
</div>

<?php include("footer.php") ?>