<?php
// Helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Inventory");
$OUTPUT = new Output();
$REQUEST = new Request();
$cart = $db->selectCollection("Cart");
$orders = $db->selectCollection("Orders");

// Must be logged in to place an order
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

// get the asset, push it into the cart that is selected
$collectionName = $REQUEST->get("collection", "Standard");
$cartName = $REQUEST->get("cart", "Default");

$old = $cart->findAndModify(
			array(
				 "user_id" => $RULES->getId()
			)
			,array(
				"cart.".$cartName => []
			)
			,array(
				'new' => false;
			)
			);

// Criteria for an order 
$document = $orders->insert(
			array( // update
				"user_id" => $RULES->getId()
				"items" => $old["cart"][$cartName]
				"status.shipped" => false
				"status.recieved" => false
				"status.paid" => false
				"status.modified" => false
				"status.processed" => false
				"status.finalized" => false	
			));

// Used for anayltics
$LOG = new Logging("Cart.order");
$LOG->log($RULES->getId(), 42, 2,100, "User Ordered item");

$OUTPUT->success(0,$document, null);

?>
