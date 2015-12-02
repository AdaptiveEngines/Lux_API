<?php
/* Reformatted 12.11.2015 */
// Helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create database Connection
$db = new Db("Auth");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin priveleges needed
$RULES = new Rules(5, "providers");

// Selects Collection from Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Providers");
$collection = $db->selectCollection($collectionName);

$query = Helper::formatQuery($REQUEST, "provider_name");
// Used for Analytics

$LOG = new Logging("API.query");
$LOG->log($RULES->getId(), 12, $query,100, "User Queried Provider");

// Format Query
$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"App"));

// Find Documents in Collection
$documents = $collection->find($query);

// Output
$OUTPUT->success(1,$documents);

?>

  
