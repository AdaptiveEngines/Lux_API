<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$OUTPUT = new Output();
$REQUEST = new Request();
$RULES = new Rules(1);
$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");



if($REQUEST->avail("email")){
	$eVC = bin2hex(openssl_random_pseudo_bytes(16));
	$query = array("system_info.access_token"=>$REQUEST->get("access_token"));
	if($REQUEST->avail("id")){
		$RULES = new Rules(5, "accounts");
		$query = $REQUEST->get("id");
	}
	$collection->update($query
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
$OUTPUT->success(0, "Email Added to existing user");

