<?php
// Helpers and inludes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("SocialNetwork");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Users");


// Values that are permitted
$permitted = array(
		 "profile_name"
		,"profile_picture"
		,"bio"
		,"images[]"
	);

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
$OUTPUT->success(0,$document, null);

?>
