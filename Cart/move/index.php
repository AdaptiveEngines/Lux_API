<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Inventory");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Cart");
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

// get the asset, push it into the cart that is selected

$collectionName = $REQUEST->get("collection", "Standard");
$wishlistName = $REQUEST->get("wishlist", "Default");
$cartName = $REQUEST->get("cart", "Default");

$old = $collection->findOne(array(
				 "user_id" => $RULES->getId()
			));

$document = $collection->findAndModify(
			array( //query
				 "user_id" => $RULES->getId()
			)
			,array( // update
				'$push' => array( "cart.".$cartName => array( '$each' => $old["wishlist"][$wishlistName]))
			));

$OUTPUT->success(0,$document, null);

?>
