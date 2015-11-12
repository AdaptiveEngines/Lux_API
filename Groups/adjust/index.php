<?php
/* Reformatted 12.11.2015 */
// helpers and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("SocialNetwork");
$OUTPUT = new Output();

// Get Request Variables 
$REQUEST = new Request();

$collectionName = Helper::getCollectionName($REQUEST, "Groups");
$collection = $DB->selectCollection($collectionName);

// Values which are permitted by the adjustment script
$permitted = array(
		 "profile_name"
		,"profile_picture"
		,"bio"
		,"images[]"
	);

// Format Update and Options
$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "providers.system");
$options = Helper::formatOptions($REQUEST);

if($REQUEST->avail("id")){
	$RULES = new Rules(5, "profile");
	$document = $collection->findAndModify($REQUEST->get("id"), $update, $options);
}else{
	$RULES = new Rules(1, "profile");
	$document = $collection->findAndModify($RULES->getId(), $update, $options);
}

// Output
$OUTPUT->success(0,$document, null);

?>
