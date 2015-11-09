<?php
// Helper function's and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Assets");
$OUTPUT = new Output();
$REQUEST = new Request();

// Groups of collections need to be modified sometimes
$collectionName = $REQUEST->avail("collection") ? $REQUEST->get("collection") : "Standard";
$collection = $db->selectCollection($collectionName);
$RULES = new Rules(0, "assets");
$OWNERSHIP = new Ownership($RULES);

// Format a query from the request
$query = Helper::formatQuery($REQUEST);

// Used for analytics
$LOG = new Logging("Asset.query");
$LOG->log($RULES->getId(), 32, $query,100, "User Queried Asset");

$document = $OWNERSHIP->query($collection->find($query));

$OUTPUT->success(1,$document);

?>

  
