<?php
/* Reformatted 12.11.2015 */
// Helper script and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin privleges needed
$RULES = new Rules(5, "accounts");

// Selects Collection from Databse Connection
$collectionName = Helper::getCollectionName($REQUEST, "Accounts", false);
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "user", "system_info.user");

// Used for Analytics
$LOG = new Logging("Accounts.query");
$LOG->log($RULES->getId(), 2, $RULES->getId(),100, "User Account Queried");

// Find Documents in Collection 
$documents = $collection->find($query);

// Output
$OUTPUT->success(0,$documents);

?>

  
