<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Messages");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$query = Helper::formatQuery($REQUEST, "id", "thread_id");

$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);
?>

