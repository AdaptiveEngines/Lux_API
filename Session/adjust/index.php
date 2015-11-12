<?php
/* Reformatted 12.11.2015 */
// Helper Function and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Variables 
$REQUEST = new Request();

$RULES = new Rules(0, "session");

$collectionName = Helper::getCollectionName($REQUEST, "Session");
$collection = $DB->selectCollection($collectionName);

// Create new Session if none exists
if($REQUEST->avail("sid")){
	$SESSION = new Session($REQUEST->get("sid"));
}else{
	$SESSION = new Session();
}

// All values are accepted by the adjustment script
$permitted = array();

// Format Update and Options
$params = $REQUEST->getParameters();
unset($params["sid"]);
$update = Helper::udpatePermitted($REQUEST, $permitted);
$options = Helper::formatOptions($REQUEST);

// Add each variable to session
foreach($params as $key => $value){
	$SESSION->set($key, $value);
}

// Find and Modify Documents in Collection
$documents = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$SESSION->get(), $documents);

?>
