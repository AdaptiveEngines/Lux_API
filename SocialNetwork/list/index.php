<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Connections");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

if($REQUEST->avail("id")){
	$id = $REQUEST->get("id");
}else{
	$id = $RULES->getId();
}

$query = array(
		'$or' => array(
			 array('requestor' => $id)
			,array('requestee' => $id)
		)
		,'status.blocked' => 0
		,'$or' => array(
			 array('status.pending' => 1)
			,array('status.active' => 1)
		)
);
$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);
?>

