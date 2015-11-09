<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Inventory");
$OUTPUT = new Output();
$REQUEST = new Request();
$orders = $db->selectCollection("Orders");
$RULES = new Rules(1, "orders");
$REQUEST = new Request();

// get the asset, push it into the cart that is selected
$document = $orders->findAndUpdate(
			Helper::formatQuery($REQUEST)
			,array( // update
				"shipper_id" => $RULES->getId()
				"status.shipped" => true
				"status.recieved" => true
				"status.paid" => true
				"status.modified" => true
				"status.processed" => true
				"status.finalized" => true
			));

$OUTPUT->success(0,$document, null);

?>
