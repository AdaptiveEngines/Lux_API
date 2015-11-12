<?php
/* Reformatted 12.11.2015 */
// Helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database connection
$DB = new Db("Inventory");
$OUTPUT = new Output();

// Get Request Data
$REQUEST = new Request();

// Admin Privleges needed
$RULES = new Rules(1, "cart");

// Selects Collection from database connection
$collectionName = Helper::getCollectionName($REQUEST, "Cart");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "user_id");

// Used for analytics
$LOG = new Logging("Cart.query");
$LOG->log($RULES->getId(), 42, 3,100, "User viewed items in cart/wishlist");

// Find Document in Collection
$document = $collection->findOne($query);

// Output
$OUTPUT->success(0,$document);

?>

  
