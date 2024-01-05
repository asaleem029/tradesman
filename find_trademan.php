<?php
include_once 'header.php';
include_once 'connect_db.php';
include_once 'classes/user.php';
include_once 'classes/trade.php';

$trade = new Trade();
$trades = $trade->getTradesList($db);
$tradesman_list = array();

// FIND TRADESMAN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'FIND_TRADEMAN') {
	$user_obj = new User();
	$tradesman_list = $user_obj->getTradesman($db, $_POST);
}
?>

<form action="find_trademan.php" method="post">
	<input type="hidden" name="action_type" value="FIND_TRADEMAN">

	<div class="form-group">
		<div class="row">
			<div class="input-group tm-search-bar">
				<input type="text" class="form-control m-1" name="city" placeholder="City..." value="<?= isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : ''  ?>">

				<select class="form-control m-1" name="trade_id" id="">
					<option value="">-- Select Trade --</option>
					<?php foreach ($trades as $trade) { ?>
						<option <?= isset($_POST['trade_id']) && !empty($_POST['trade_id']) && $_POST['trade_id'] == $trade['id'] ? "selected=selected" : '' ?> value="<?= $trade['id'] ?>"><?= $trade['name'] ?></option>
					<?php } ?>
				</select>

				<input type="date" class="form-control m-1" name="date" value="<?= isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : '' ?>">

				<div class="input-group-prepend m-1">
					<button class="btn btn-primary" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<?php if (isset($tradesman_list) && !empty($tradesman_list)) {
	foreach ($tradesman_list as $key => $trademan) {
		$trade = new Trade();
		$trade_name = $trade->getTrade($db, $trademan['trade_id']); ?>

		<div class="container mt-5">
			<div class="row d-flex justify-content-center">
				<div class="col-md-7">
					<div class="card p-3 py-4">

						<div class="text-center mt-3">
							<h2 class="mt-2 mb-0">
								<?= $trademan['name'] ?>
							</h2>

							<div class="row">
								<div class="col">

									<h4 class="mt-2 mb-0">
										<label for="">Phone No.</label>
										<?= $trademan['phone'] ? $trademan['phone'] : "--"  ?>
									</h4>
								</div>

								<div class="col">
									<h4 class="mt-2 mb-0">
										<label for="">Trade</label>
										<?= isset($trade_name['name']) && !empty(isset($trade_name['name'])) ? $trade_name['name'] : "--"  ?>
									</h4>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<h4 class="mt-2 mb-0">
										<label for="">Hourly Rate</label>
										<?= $trademan['hourly_rate'] ? $trademan['hourly_rate'] : "--"  ?>
									</h4>
								</div>

								<div class="col">
									<h4 class="mt-2 mb-0">
										<label for="">Rating</label>
										<?= $trademan['trademan_rating'] ? $trademan['trademan_rating'] : "--"  ?>
									</h4>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<div id="rating_stars_<?= $key + 1 ?>" class="rating_stars" data-id="<?= $key + 1 ?>" data-rating="<?= $trademan['trademan_rating'] ?>"></div>
								</div>

								<div class="col">
									<a href="view_profile.php?id=<?= $trademan['id'] ?>">
										View Profile
										<i class="fa-solid fa-forward"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }
} else { ?>
	<div class="text-center text-danger">
		<span>
			Oops...No Trademan Found
		</span>
	</div>
<?php } ?>

<?php include 'footer.php' ?>