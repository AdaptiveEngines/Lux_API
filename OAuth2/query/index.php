<?php
/* Reformatted 12.11.2015 */
// Helper script and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Auth");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin Privleges Required
$RULES = new Rules(5, "oauth");

// Selects Collection from Databse Connection
$collectionName = Helper::getCollectionName($REQUEST, "Clients");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "client_name");

// Used for anayltics
$LOG = new Logging("OAuth.query");
$LOG->log($RULES->getId(), 72, $query,100, "OAuth Providers Queried");

// Find Documents in Collection
$documents = $collection->find($query);

// Output
$OUTPUT->success(0,$documents);

?>

  
