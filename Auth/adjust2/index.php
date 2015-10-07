<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

$permitted = array("provider_name","base1", "base2", "base3", "client_id", "client_secret", "default_scope");

$update = Helper::updatePermitted($REQUEST, $permitted);
$update["protocol"] = "OAuth2";
$query = array("provider_name" => $REQUEST->get("provider_name")); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
