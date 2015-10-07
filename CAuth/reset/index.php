<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Users");
$RULES = new Rules(1);
$OUTPUT = new Output();
$REQUEST = new Request();
$document = $collection->findOne(array('$or' => array( 
					array("system_info.user" => $REQUEST->get("user"))
					array("system_info.email" => $REQUEST->get("user"))
				)));

if(!is_null($document) && isset($document["system_info"]["email"])){
	$password = bin2hex(openssl_random_pseudo_bytes(8));
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$collection->update($document["_id"]
			,array('$set' => array(
					 "system_info.hash" => $hash
			))
	);		
	$to      = $document["system_info"]["email"];
	$subject = 'Email Verification';
	$message = "A password reset link was sent to your email address. Your new password is $password";
	$headers = 'From: no-reply@'.$_SERVER["HTTP_HOST"] . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);	
	$OUTPUT->success(0, "Password Reset Email Sent");
}else{
	$OUTPUT->error(1, "Username/Email was not found in the system");
}

