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
				<input type="text" class="form-control m-1" name="city" placeholder="City...">

				<select class="form-control m-1" name="trade_id" id="">
					<option value="">-- Select Trade --</option>
					<?php foreach ($trades as $trade) { ?>
						<option value="<?= $trade['id'] ?>"><?= $trade['name'] ?></option>
					<?php } ?>
				</select>

				<input type="date" class="form-control m-1" name="date" placeholder="Search...">

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
										<?= $trademan['phone'] ? $trademan['phone'] : "--"  ?>
									</h4>
								</div>

								<div class="col">
									<h4 class="mt-2 mb-0">
										<?= isset($trade_name['name']) && !empty(isset($trade_name['name'])) ? $trade_name['name'] : "--"  ?>
									</h4>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<h4 class="mt-2 mb-0">
										<?= $trademan['hourly_rate'] ? $trademan['hourly_rate'] : "--"  ?>
									</h4>
								</div>

								<div class="col">
									<h4 class="mt-2 mb-0">
										<?= $trademan['trademan_rating'] ? $trademan['trademan_rating'] : "--"  ?>
									</h4>
								</div>
							</div>

							<div id="rating_stars_<?= $key + 1 ?>" class="rating_stars" data-id="<?= $key + 1 ?>" data-rating="<?= $trademan['trademan_rating'] ?>"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php }
} ?>

<?php include 'footer.php' ?>