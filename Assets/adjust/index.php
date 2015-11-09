<?php
// Helper function's and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Assets");
$OUTPUT = new Output();
$REQUEST = new Request();

// Allows user to switch away from a standard collection
$collectionName = $REQUEST->avail("collection") ? $REQUEST->get("collection") : "Standard";
$collection = $db->selectCollection($collectionName);

// Anyone can create or change assets
// but individual assets are controlled by Ownership rules 
$RULES = new Rules(0, "assets");
$OWNERSHIP = new Ownership($RULES);


$update = Helper::updatePermitted($REQUEST);
$query = Helper::formatQuery($REQUEST);
$query = $OWNERSHIP->adjust($collection, $query);

// Used for Analytics
$LOG = new Logging("Asset.adjust");
$LOG->log($RULES->getId(), 31, $query, 100, "User Modified Asset");

$options = Helper::formatOptions($REQUEST);

$document = $collection->findAndModify($query, $update, $options);
$OWNERSHIP->check($document);
$OUTPUT->success(0,$document, null);

?>
