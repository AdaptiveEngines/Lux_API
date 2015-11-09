<?php
// Helper and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Inventory");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Cart");

// User needs to be logged in to access their cart
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

$query = array("status.finalized" => false);
$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);

?>

  
