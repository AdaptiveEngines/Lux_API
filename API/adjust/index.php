<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

$LOG = new Logging("API.adjust");
$LOG->log($RULES->getId(), 11, $REQUEST->get("provider"),100, "User Modified Provider");

$permitted = array("key", "base_url", "key_name", "provider_name");

$update = Helper::updatePermitted($REQUEST, $permitted);

$update["protocol"] = "App";

$query = array("provider"=>$REQUEST->get("provider")); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
