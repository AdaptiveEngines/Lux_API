<?php
// Helper functions and includs
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Inventory");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Cart");
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

// get the asset, push it into the cart that is selected

$collectionName = $REQUEST->get("collection", "Standard");
$cartName = $REQUEST->get("wishlist", "Default");

$document = $collection->findAndModify(
			array( //query
				 "user_id" => $RULES->getId()
			)
			,array( // update
				'$push' => array( "wishlist.".$cartName => MongoDBRef::create($collectionName, $REQUEST->get("id"), "Assets"))
			));

// Used for analytics
$LOG = new Logging("Cart.order");
$LOG->log($RULES->getId(), 43, $REQUEST->get("id"),100, "User Wished for item");
$OUTPUT->success(0,$document, null);

?>
