<?php
/* Reformatted 12.11.2015 */
// Helper script and include
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// No Privleges Needed
$RULES = new Rules(0, "session");

// Selects Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Sessions");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "sid");

// Used for anayltics
$LOG = new Logging("Session.query");
$LOG->log($RULES->getId(), 102, $query,100, "Session Variable Queried");

// Find Documents in Collection 
$documents = $collection->find($query);


// Only Available for Sessions: 
if($REQUEST->avail("sid")){
	$SESSION = new Session($REQUEST->get("sid"));
}else{
	$SESSION = new Session();
}

if($REQUEST->avail("key")){
	$OUTPUT->success(1,$SESSION->get($REQUEST->get("key")), $documents);
}else{
	$OUTPUT->success(1,$SESSION->get(), $documents);
}

?>

  
