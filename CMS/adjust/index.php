<?php
/* Reformatted 12.11.2015 */
// Helper and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// Admin Privleges needed
$RULES = new Rules(5, "cms");

// Select Collection From Database Connection 
$collectionName = Helper::getCollectionName($REQUEST, "Content");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "field_name");

// Values which are permitted by the Adjustment Script
$permitted = array("field_name", "content.full", "content.short", "header.text","header.sub", "header.url_safe", "picture.banner", "picture.other[]", "picture.slideshow[]");

// Format Update and options
$update = Helper::updatePermitted($REQUEST, $permitted);
$options = Helper::formatOptions($REQUEST);

// Used for analytics
$LOG = new Logging("CMS.adjust");
$LOG->log($RULES->getId(), 51, $query,100, "Content Updated");

// Find And Modify Documents in Collection
$document = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$document);

?>

  
