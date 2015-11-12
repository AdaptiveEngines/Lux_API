<?php
/* Reformatted 12.11.2015 */
// Helper script and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$db = new Db("SocialNetwork");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// No Privleeges needed
$RULES = new Rules(0, "profile");


// Select Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Users");
$collection = $db->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST);

// Used for anayltics
$LOG = new Logging("Profile.query");
$LOG->log($RULES->getId(), 92, $query,100, "Social Network Profile Queried");

// Find Documents
$documents = $collection->find($query);

// Output
$OUTPUT->success(1,$documents);

?>

  
