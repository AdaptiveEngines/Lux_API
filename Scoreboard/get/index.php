<?php
/* Reformatted 12.11.2015 */
// Helper function's and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$db = new Db("Scoreboard");
$OUTPUT = new Output();

// Get Request Variables 
$REQUEST = new Request();

// No Priveleges needed
$RULES = new Rules(0, "scoreboard");

// Select collection 
$collectionName = Helper::getCollectionName($REQUEST, "Users");
$collection = $db->selectCollection($collectionName);

// Find Ownership Rules 
$OWNERSHIP = new Ownership($RULES);

// Format a query from the request
$query = Helper::formatQuery($REQUEST, "user_id", "user_id");

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
