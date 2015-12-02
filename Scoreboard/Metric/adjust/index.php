<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Scoreboard");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Users");
$RULES = new Rules(1, "scoreboard");
$REQUEST = new Request();

$quantity = intval($REQUEST->get("change", false) ? $REQUEST->get("change") : $REQUEST->get("value"));
$operator = $REQUEST->get("change", false) ? '$inc' : '$set';

$metric = $REQUEST->get("metric");

$document = $collection->findAndModify(
			array( //query
				 "user_id" => $RULES->getId()
			)
			,array( // update
				$operator => array( "Metrics.".$metric => $quantity)
			));

$LOG = new Logging("Scoreboard.metric");
$LOG->log($RULES->getId(), 63, $REQUEST->get("metric"),$quantity, "User adjusted metric");

$OUTPUT->success(0,$document, null);

?>
