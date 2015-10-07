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

$query = array('$and' => array(
		 '$or' => array('requestor' => $id, 'requestee' => $id)
		,'status.blocked' => 0
		,'$or' => array(
			 'status.pending' => 1
			,'status.active' => 1
		)
));
$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);
?>

