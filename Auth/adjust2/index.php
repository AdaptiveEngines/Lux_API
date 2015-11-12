<?php
/* Reformatted 12.11.2015 */
// helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Auth");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// Admin privleges needed
$RULES = new Rules(5, "providers");

// Select Collection From Database
$collectionName = Helper::getCollectionName($REQUEST, "Providers");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "provider_name"); 

// Values which are accepted by the adjustment Script
$permitted = array("provider_name","base1", "base2", "base3", "client_id", "client_secret", "default_scope");

// Used for Analytics
$LOG = new Logging("Auth1.adjust");
$LOG->log($RULES->getId(), 111, $query, 100, "User Modified Asset");

// Format Update and Options
$update = Helper::updatePermitted($REQUEST, $permitted);
$update["protocol"] = "OAuth2";
$options = Helper::formatOptions($REQUEST);

// Find and Modify Documents in Collection
$documents = $collection->findAndModify($query, $update, $options);
$OUTPUT->success(0,$documents);

?>

  
