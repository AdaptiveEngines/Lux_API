<?php
/* Reformatted 12.11.2015 */
// Helpers and inludes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("SocialNetwork");
$OUTPUT = new Output();

// get Request Variables 
$REQUEST = new Request();

// Select Collection From Databse Connection
$collectionName = Helper::getCollectionName($REQUEST, "Users");
$collection = $DB->selectCollection($collectionName);

// Values which are accepted by the adjustment script
$permitted = array(
		 "profile_name"
		,"profile_picture"
		,"bio"
		,"images[]"
	);

// Foramt Update and Options
$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "providers.system");
$options = Helper::formatOptions($REQUEST);


// Any profile can be changed by an admin, a normal user 
// can only change their own profile.
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
