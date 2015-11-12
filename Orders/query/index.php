<?php
/* Reformatted 12.11.2015 */
// Helpers and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Inventory");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// User needs to be logged in for access
$RULES = new Rules(1, "cart");

// Select Collection from Connection
$collectionName = Helper::getCollectionName($REQUEST, "Cart");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = array("user_id" => $RULES->getId());

// Used for anayltics
$LOG = new Logging("OAuth.query");
$LOG->log($RULES->getId(), 72, $query,100, "OAuth Providers Queried");

// Format Limits (Skip, Limit)
$options = Helper::formatLimits($REQUEST);

// Find Documents 
$documents = $collection->find($query, $options);

// Output
$OUTPUT->success(0,$documents);

?>

  
