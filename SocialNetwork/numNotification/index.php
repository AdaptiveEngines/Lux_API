<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Notifications");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$query = array("user_id" => $RULES->getId(), "status.seen" => 0);

$document = $collection->count($query); 
$OUTPUT->success(0,$document);
?>

