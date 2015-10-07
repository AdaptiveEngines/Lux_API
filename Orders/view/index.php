<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Inventory");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Cart");
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

$options = Helper::formatLimits($REQUEST);
$document = $collection->find(array(), $options);
$OUTPUT->success(0,$document);

?>

  
