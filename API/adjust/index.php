<?php
// Helper function and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");

// Admin privleges needed
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

// Used for Analytics
$LOG = new Logging("API.adjust");
$LOG->log($RULES->getId(), 11, $REQUEST->get("provider"),100, "User Modified Provider");

// Values required for this type of API
$permitted = array("key", "base_url", "key_name", "provider_name");
$update = Helper::updatePermitted($REQUEST, $permitted);
$update["protocol"] = "App";

// Save values for this API
$query = array("provider"=>$REQUEST->get("provider")); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
