<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Accounts");
$REQUEST = new Request();
$RULES = new Rules(5, "accounts");

$LOG = new Logging("Accounts.adjust");
$LOG->log($RULES->getId(), 1, $RULES->getId(),100, "User Modified Account");

$permitted = array("user", "email", "role", "permissions[]");

$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "system_info");

$query = array("system_info.user" => $REQUEST->get("user")); 
$document_old = $collection->findOne($query);

$results = $collection->update($query, $update);
$document = $collection->findOne($query);

if(is_null($document_old) && isset($document["system_info"]["email"])){
	$password = bin2hex(openssl_random_pseudo_bytes(8));
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$collection->update($document["_id"]
			,array('$set' => array(
					 "system_info.hash" => $hash
			))
	);		
	$user = $document["system_info"]["user"];
	$to      = $document["system_info"]["email"];
	$subject = 'Email Verification';
	$message = "An account was created for you by an admistrator. Your user name is \n\n $user and password is \n\n $password";
	$headers = 'From: no-reply@'.$_SERVER["HTTP_HOST"] . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);	
	$OUTPUT->success(0, $document, $results);
}else{
	$OUTPUT->success(0, $document, $results);
}

?>

