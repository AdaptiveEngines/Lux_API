<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Inventory");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Cart");
$RULES = new Rules(1, "cart");
$REQUEST = new Request();

$query = array("user_id" => $RULES->getId());
$document = $collection->findOne($query);
$OUTPUT->success(0,$document);

?>

  