<?php
/* Reformatted 12.11.2015 */
// Helpers and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Databse Connection 
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin privleges required
$RULES = new Rules(5, "contact");

// Selects Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Contact");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "email_id");

// Used for anayltics
$LOG = new Logging("Contact.query");
$LOG->log($RULES->getId(), 62, $query,100, "Contacts Queried");

// Get Documents
$documents = $collection->find($query);

// Output
$OUTPUT->success(0,$documents);

?>

  
