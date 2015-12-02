<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Scoreboard");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Users");
$RULES = new Rules(1, "scoreboard");
$REQUEST = new Request();

$operator = $REQUEST->get("remove", false) ? '$pull' : '$push'; 

$document = $collection->findAndModify(
			array( //query
				 "user_id" => $RULES->getId()
			)
			,array( // update
				'$set' => array( "Levels.".$REQUEST->get("level_id").".sub_levels.".$REQUEST->get("sub_level_id").".sub_level_id"  => $REQUEST->get("sub_level_id")
				)
			));

$LOG = new Logging("Scoreboard.level");
$LOG->log($RULES->getId(), 62, $REQUEST->get("level_id"),100, "User added level to scoreboard levels array");

$OUTPUT->success(0,$document, null);

?>
