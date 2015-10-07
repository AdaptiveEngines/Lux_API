<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$OUTPUT = new Output();
$REQUEST = new Request();
$db2 = new Db("Auth");
$OUTPUT = new Output();
$clients = $db->selectCollection("Clients");

$client_id = $REQUEST->get("client_id");
$redirect_uri = $REQUEST->get("redirect_uri");
$client_secret = $REQUEST->get("client_secret");

$client_doc = $clients->findOne(array(   "client_id" => $client_id
					,"client_secret" => $client_secret
					,"redirect_uri"=>array(
							'$elemMatch' => array( '$in' => array($redirect_uri)))
					));

// get Password and Username from $REQUEST
// /client_id	/redirect_uri	/client_secret	/code	/grant_type:authorization_code



if($REQUEST->get("grant_type") != "authorization_code"){
	$OUTPUT->error(1, "Grant_type must equal authorization code in this context");
}

// find where there is a match
$uDoc = $collection->findOne(array('system_info.OAuth_clients' =>
					array('$elemMatch' => array( '$in' => array(array(
							 "client_id" => $REQUEST->get("client_id")
							,"code" => $REQUEST->get("code")
						)))
					)
				));
if(is_null($uDoc)){
	$OUTPUT->error(1, "This code is either invalid or has already been redeemed");
}
$lAT = bin2hex(openssl_random_pseudo_bytes(16));
$document = $collection->update(array('_id' => $uDoc["_id"])
				,array('$pull' =>
					array('system_info.OAuth_clients' => array(
							 "client_id" => $REQUEST->get("client_id")
							,"code" => $REQUEST->get("code")
						)
					)
				)
				,array('multiple'=>false, 'upsert'=>true)
			);
$document = $collection->update(array('_id' => $uDoc["_id"])
				,array('$addToSet' =>
					array('system_info.OAuth_clients' => array(
							 "client_id" => $REQUEST->get("client_id")
							,"access_token" => $lAT
						)

					)
				)
				,array('multiple'=>false, 'upsert'=>true)
				);
		$OUTPUT->success(1, 
				array(
					 "access_token" => $lAT
					)
			);
		die();
