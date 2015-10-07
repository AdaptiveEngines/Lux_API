<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");
$RULES = new Rules(5, "providers");
$REQUEST = new Request();


$LOG = new Logging("API.query");
$LOG->log($RULES->getId(), 12, $REQUEST->get("provider"),100, "User Queried Provider");

$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"App"));
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
