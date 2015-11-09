<?php
// Helper fucntions and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$RULES = new Rules(1);
$OUTPUT = new Output();
$REQUEST = new Request();

$document = $collection->findOne(array("system_info.access_token" => $REQUEST->get("access_token")));
if(password_verify($REQUEST->get("password"), $document["system_info"]["hash"])){
	$lAT = bin2hex(openssl_random_pseudo_bytes(16));
	$hash = password_hash($REQUEST->get("new_password"), PASSWORD_DEFAULT);
	if($hash){
	// save $lAT into database
		$collection->update(array("_id"=>$document["_id"])
				,array('$set' => array(
						 "system_info.access_token" => $lAT
						,"system_info.hash"=>$hash
					))
				,array('multiple'=>false, 'upsert'=>true)
		);
		$OUTPUT->success(1, "Password Changed", 
				array(
					 "access_token" => $lAT
					,"user" => $document["system_info"]["user"]
					)
			);
	}
}else{
	$OUTPUT->error(0, "Incorrect Username or Password");
}

