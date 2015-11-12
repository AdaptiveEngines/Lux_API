<?php
/* Reformatted 12.11.2015 */
// Helper function and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Auth");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// Admin privleges needed
$RULES = new Rules(5, "providers");

// Select Collection From Databse Connection
$collectionName = Helper::getCollectionName($REQUEST, "Providers");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "provider");

// Value's which are accepted by the adjustment script
$permitted = array("key", "base_url", "key_name", "provider_name");

// Format update and options
$update = Helper::updatePermitted($REQUEST, $permitted);
$update["protocol"] = "App";
$options = Helper::formatOptions($REQUEST);

// Used for Analytics
$LOG = new Logging("API.adjust");
$LOG->log($RULES->getId(), 11, $REQUEST->get("provider"),100, "User Modified Provider");

// Find And Modify Documents in Collection
$documents = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$documents);

?>

  
