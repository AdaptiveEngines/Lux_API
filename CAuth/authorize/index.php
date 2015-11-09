<?php
// Helper functions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$OUTPUT = new Output();
$REQUEST = new Request();

// get Password and Username from $REQUEST
$document = $collection->findOne(array('$or' => array( 
					 array("system_info.user" => $REQUEST->get("user"))
					,array("system_info.email" => $REQUEST->get("user"))
				)));

if(password_verify($REQUEST->get("password"), $document["system_info"]["hash"])){
	$lAT = bin2hex(openssl_random_pseudo_bytes(16));
	// save $lAT into database
	if($REQUEST->avail("response_type") && $REQUEST->get("response_type") == "code"){
		$collection->update(array("_id"=>$document["_id"])
				,array('$addToSet' => array("system_info.OAuth_clients" => 
					array(
						 "client_id" => $REQUEST->get("client_id")
						,"code" => $lAT
					)
				))
				,array('multiple'=>false, 'upsert'=>true)
		);
		$OUTPUT->success(1, 
				array(
					"code" => $lAT
					)
			);
		die();
	}
	$collection->update(array("_id"=>$document["_id"])
			,array('$set' => array("system_info.access_token" => $lAT))
			,array('multiple'=>false, 'upsert'=>true)
	);
	$OUTPUT->success(1, 
			array(
				 "access_token" => $lAT
				,"user" => $document["system_info"]["user"]
				)
		);
}else{
	$OUTPUT->error(0, "Incorrect Username or Password");
}

