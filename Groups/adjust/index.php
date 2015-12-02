<?php
/* Reformatted 12.11.2015 */
// Helper function's and includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("SocialNetwork");
$OUTPUT = new Output();

// Get Request Variables
$REQUEST = new Request();

// No privleges needed, Ownership rules apply
$RULES = new Rules(0, "assets");
$OWNERSHIP = new Ownership($RULES);

// Allows user to switch away from a standard collection
$collectionName = Helper::getCollectionName($REQUEST, "Groups");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST);
$query = $OWNERSHIP->adjust($collection, $query);

// Values which are accepted by the Adjustment script
$permitted = array(
		 "group_name"
		,"group_picture"
		,"bio"
		,"images[]"
	);

// Format Update and Options 
$update = Helper::updatePermitted($REQUEST, $permitted);
$options = Helper::formatOptions($REQUEST);

// Used for Analytics
//$LOG = new Logging("Asset.adjust");
//$LOG->log($RULES->getId(), 31, $query, 100, "User Modified Asset");

// Find and Modify documents in collection
$documents = $collection->findAndModify($query, $update, $options);

// Output
$OUTPUT->success(0,$documents, null);

?>
