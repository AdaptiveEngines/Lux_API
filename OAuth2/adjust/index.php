<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Auth");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Clients");
$REQUEST = new Request();
$RULES = new Rules(5);

$permitted = array("client_name", "description", "redirect_uri[]");

$update = Helper::updatePermitted($REQUEST, $permitted);

$query = array("client_name" => $REQUEST->get("client_name")); 
$document = $collection->findOne($query);
if(is_null($document)){
	$client_id = bin2hex(openssl_random_pseudo_bytes(16));
	$client_secret = bin2hex(openssl_random_pseudo_bytes(16));
	$update['$set']["client_secret"] = $client_id;
	$update['$set']["client_id"] = $client_secret;
}
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
