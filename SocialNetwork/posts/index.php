<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Posts");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

if($REQUEST->avail("id")){
	$id = $REQUEST->get("id");
}else{
	$id = $RULES->getId();
}

$query = array(
		"owner" => $id
);

$options = Helper::formatLimits($REQUEST);
$document = $collection->find($query, $options);
$OUTPUT->success(0,$document);
?>

