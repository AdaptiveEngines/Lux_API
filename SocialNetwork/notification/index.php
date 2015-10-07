<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Notifications");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$query = array("user_id" => $RULES->getId());
$update = array("status.seen" => 1);

$options = Helper::formatLimits($REQUEST);
$options["upsert"] = false;
$document = $collection->findAndModify($query, $update, $options);
$OUTPUT->success(0,$document);
?>

