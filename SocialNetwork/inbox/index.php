<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Messages");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$query = array('root' => '1', array( 'participants' => $RULES->getId()));
$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);
?>

