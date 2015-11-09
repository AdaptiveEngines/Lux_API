<?php
// Helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");

// Admin priveleges needed to query or edit API providers directly
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

// Used for Analytics
$LOG = new Logging("API.query");
$LOG->log($RULES->getId(), 12, $REQUEST->get("provider"),100, "User Queried Provider");

// APIs can only be queried by provider_name
$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"App"));
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
