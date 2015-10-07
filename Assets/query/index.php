<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Assets");
$OUTPUT = new Output();
$REQUEST = new Request();
$collectionName = $REQUEST->avail("collection") ? $REQUEST->get("collection") : "Standard";
$collection = $db->selectCollection($collectionName);
$RULES = new Rules(0, "assets");
$OWNERSHIP = new Ownership($RULES);

$LOG = new Logging("Asset.query");

$query = Helper::formatQuery($REQUEST);
$LOG->log($RULES->getId(), 32, $query,100, "User Queried Asset");

$document = $OWNERSHIP->query($collection->find($query));

$OUTPUT->success(1,$document);

?>

  
