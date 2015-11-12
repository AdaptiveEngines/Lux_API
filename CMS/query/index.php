<?php
/* Reformatted 12.11.2015 */
// Helper and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// No Privleges Needed
$RULES = new Rules(0, "cms");

// Select Collection From database
$collectionName = Helper::getCollectionName($REQUEST, "Content");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "field_name");

// Used for anayltics
$LOG = new Logging("CMS.query");
$LOG->log($RULES->getId(), 52, $query,100, "Content Viewed");

// Find Documents in Collection
$documents = $collection->find($query);

// Output
$OUTPUT->success(0,$documents);

?>

  
