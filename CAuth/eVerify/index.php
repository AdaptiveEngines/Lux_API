<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$REQUEST = new Request();

if($REQUEST->avail("email")){
	$document = $collection->update(array(
				 "system_info.email" => $REQUEST->get("email")
				,"system_info.eVerified" => $REQUEST->get("eVC"))
			,array('$set' => array(
					 "system_info.email" => $REQUEST->get("email")
					,"system_info.eVerified" => true
			))
			,array('multiple'=>false, 'upsert'=>true)
	);
	header('Location: /?access_token='.$document["system_info"]["access_token"]);
}

