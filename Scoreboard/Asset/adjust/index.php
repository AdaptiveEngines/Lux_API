<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Scoreboard");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Users");
$RULES = new Rules(1, "scoreboard");
$REQUEST = new Request();

$quantity = intval($REQUEST->get("quantity", "1"));
$asset_id = $REQUEST->get("asset_id");

$document = $collection->findAndModify(
			array( //query
				 "user_id" => $RULES->getId()
			)
			,array( // update
				'$inc' => array( "assets.".$asset_id.".quantity" => $quantity)
			));

$LOG = new Logging("Scoreboard.asset");
$LOG->log($RULES->getId(), 61, $REQUEST->get("asset_id"),$quantity, "User added item to scoreboard Possessions");

$OUTPUT->success(0,$document, null);

?>
