<?php
/* Reformatted 12.11.2015 */
// Helper and Include functions
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Auth");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// Admin Privleges needed
$RULES = new Rules(5, "oauth");

// Select Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Clients");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "client_name"); 

// Value's which are accepted by the adjustment script
$permitted = array("client_name", "description", "redirect_uri");

// Format Update and Options
$update = Helper::updatePermitted($REQUEST, $permitted);
$options = Helper::formatOptions($REQUEST);

// generate client_secret/id if not already generated
$client_id = bin2hex(openssl_random_pseudo_bytes(16));
$client_secret = bin2hex(openssl_random_pseudo_bytes(16));
$update['$setOnInsert']["client_secret"] = $client_id;
$update['$setOnInsert']["client_id"] = $client_secret;

// Find and Modify Documents in Collection
$documents = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$documents);

?>

  
