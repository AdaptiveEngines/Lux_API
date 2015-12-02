<?php
/* Reformatted 12.11.2015 */
// Helper and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// Admin privleges required
$RULES = new Rules(5, "contact");

// Select Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Contact");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "email_id"); //array("email_id" => $REQUEST->get("email_id")); 

// values that are accepted by the adjustment script
$permitted = array("address[]","address", "sender", "email_id");

// Format and Update Options
$update = Helper::updatePermitted($REQUEST, $permitted);
$options = Helper::formatOptions($REQUEST);

// Used for analytics
$LOG = new Logging("Contact.adjust");
$LOG->log($RULES->getId(), 61, $query,100, "Content Updated");

// Find and Modify Documents in Collection
$document = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$document);

?>

  
