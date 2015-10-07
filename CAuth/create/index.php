<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$OUTPUT = new Output();
$REQUEST = new Request();
// get Password and Username from $REQUEST


$hash = password_hash($REQUEST->get("password"), PASSWORD_DEFAULT);
if($hash){
	$lAT = bin2hex(openssl_random_pseudo_bytes(16));
	// save $lAT into database
	if($REQUEST->avail("access_token")){
		$collection->update(array("system_info.access_token"=>$REQUEST->get("access_token"))
				,array('$set' => array(
						 "system_info.access_token" => $lAT
						,"system_info.hash" => $hash
						,"system_info.user" => $REQUEST->get("user")))
				,array('multiple'=>false, 'upsert'=>true)
		);		
	}else{
		if(is_null($collection->findOne(array("system_info.user"=>$REQUEST->get("user"))))){
			$result = $collection->insert(array("system_info" =>array(
						 "access_token" => $lAT
						,"hash" => $hash
						,"user" => $REQUEST->get("user")))
			);		
		}else{
			$OUTPUT->error(1, "User exists with this Username");
		}
	}
	if($REQUEST->avail("email")){
		$eVC = bin2hex(openssl_random_pseudo_bytes(16));
		$collection->update(array("system_info.access_token"=>$REQUEST->get("access_token"))
				,array('$set' => array(
						 "system_info.email" => $REQUEST->get("email")
						,"system_info.eVerified" => $eVC
					))
				,array('multiple'=>false, 'upsert'=>true)
		);		
		$to      = $REQUEST->get("email");
		$subject = 'Email Verification';
		$url = $_SERVER["HTTP_HOST"]."/Lux/CAuth/eVerify/?email=$to&eVC=$eVC";
		$message = "Please click this link (or paste into browser) to verify email $url";
		$headers = 'From: no-reply@'.$_SERVER["HTTP_HOST"] . "\r\n" .
		    	   'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);	
	}
	$OUTPUT->success(1, 
			array(
				 "access_token" => $lAT
				,"user" => $REQUEST->get("user")
				)
		);
}else{
	$OUTPUT->error(1, "Unable to save user/password");
}

