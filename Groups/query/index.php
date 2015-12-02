<?php
/* Reformatted 12.11.2015 */
// helpers nad includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$db = new Db("SocialNetwork");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// No privleges Required
$RULES = new Rules(0, "profile");

// Selects collection from Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Groups");
$collection = $db->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "group_id");

// Used for anayltics
$LOG = new Logging("Groups.query");
$LOG->log($RULES->getId(), 72, $query,100, "Groups Queried");

// Find Documents in Collection 
$documents = $collection->find($query);

// Output
$OUTPUT->success(1,$documents);

?>

  
