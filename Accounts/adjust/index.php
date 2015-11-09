<?php
// Helper functions and other includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();

// Connects to MongoDB
$collection = $DB->selectCollection("Accounts");
$REQUEST = new Request();
$RULES = new Rules(5, "accounts");

// Used in Analytics
$LOG = new Logging("Accounts.adjust");
$LOG->log($RULES->getId(), 1, $RULES->getId(),100, "User Modified Account");


// Value's which are accepted by the adjustment script
$permitted = array("user", "email", "role", "permissions[]");
$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "system_info");


// call to databse
$query = array("system_info.user" => $REQUEST->get("user")); 
$document_old = $collection->findOne($query);


// Piped through Database Class (not Database Driver). 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);


// Handle if an Admin is creating an account. Email is needed to notify Account Holder (with password). 
if(is_null($document_old) && isset($document["system_info"]["email"])){
	$password = bin2hex(openssl_random_pseudo_bytes(8));
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$collection->update($document["_id"]
			,array('$set' => array(
					 "system_info.hash" => $hash
			))
	);		

	// Send new Account holder an Email
	$user = $document["system_info"]["user"];
	$to      = $document["system_info"]["email"];
	$subject = 'Email Verification';
	$message = "An account was created for you by an admistrator. Your user name is \n\n $user and password is \n\n $password";
	$headers = 'From: no-reply@'.$_SERVER["HTTP_HOST"] . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);	
	$OUTPUT->success(0, $document, $results);
}else{ // if account exists
	// Shows an updated of information to the front-end 
	$OUTPUT->success(0, $document, $results);
}

?>

