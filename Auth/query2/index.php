<?php
/* Reformatted 12.11.2015 */
// Helper functions adn includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("Auth");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin Privleges required
$RULES = new Rules(5, "providers");

// Selects Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Providers");
$collection = $DB->selectCollection($collectionName);

// provider name required for specific query (otherwise all will be returned)
$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"OAuth2"));

// Used for analytics
$LOG = new Logging("Auth2.query");
$LOG->log($RULES->getId(), 112, $query,100, "User viewed items in cart/wishlist");

// Find Documents in Collection
$documents = $collection->find($query);

// Output
$OUTPUT->success(1,$documents);

?>
