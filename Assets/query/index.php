<?php
/* Reformatted 12.11.2015 */
// Helper function's and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$db = new Db("Assets");
$OUTPUT = new Output();

// Get Request Variables 
$REQUEST = new Request();

// No Priveleges needed
$RULES = new Rules(0, "assets");

// Select collection 
$collectionName = Helper::getCollectionName($REQUEST, "Standard", true);
$collection = $db->selectCollection($collectionName);

// Find Ownership Rules 
$OWNERSHIP = new Ownership($RULES);

// Format a query from the request
$query = Helper::formatQuery($REQUEST);

// Used for analytics
$LOG = new Logging("Asset.query");
$LOG->log($RULES->getId(), 32, $query, 100, "User Queried Asset");

// Find Documents in Collection
$documents = $collection->find($query);

// Filter out unOwned Documents
$documents = $OWNERSHIP->query($documents);

// Output
$OUTPUT->success(1,$documents);

?>

  
