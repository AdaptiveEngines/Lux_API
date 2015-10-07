<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Assets");
$OUTPUT = new Output();
$REQUEST = new Request();
$collectionName = $REQUEST->avail("collection") ? $REQUEST->get("collection") : "Standard";
$collection = $db->selectCollection($collectionName);
$RULES = new Rules(0, "assets");
$OWNERSHIP = new Ownership($RULES);


$LOG = new Logging("Asset.adjust");

$update = Helper::updatePermitted($REQUEST);
$query = Helper::formatQuery($REQUEST);
$query = $OWNERSHIP->adjust($collection, $query);

$LOG->log($RULES->getId(), 31, $query, 100, "User Modified Asset");

$options = Helper::formatOptions($REQUEST);

$document = $collection->findAndModify($query, $update, $options);
$OWNERSHIP->check($document);
$OUTPUT->success(0,$document, null);

?>
