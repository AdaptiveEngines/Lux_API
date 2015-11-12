<?php
/* Reformatted 12.11.2015 */
// Helper functions and other includes
include_once('/var/www/html/Lux/Core/Helper.php');

// Create Database Connection
$DB = new Db("System");
$OUTPUT = new Output();

// Get Request Data 
$REQUEST = new Request();

// Admin Privleges needed
$RULES = new Rules(5, "accounts");

// Selects Collection From Database Connection
$collectionName = Helper::getCollectionName($REQUEST, "Accounts");
$collection = $DB->selectCollection($collectionName);

// Format Query
$query = Helper::formatQuery($REQUEST, "user", "system_info.user");

// Value's which are accepted by the adjustment script
$permitted = array("user", "email", "role", "permissions[]");

// Format update and options
$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "system_info");
$options = Helper::formatOptions($REQUEST);

// Get Old Document
$document_old = $collection->findOne($query);

// Used in Analytics
$LOG = new Logging("Accounts.adjust");
$LOG->log($RULES->getId(), 1, $RULES->getId(),100, "User Modified Account");


// Find and Modify Documents in Collection
$results = $collection->findAndModify($query, $update,$options);
$document = $collection->findOne($query);

// Handle if an Admin is creating an account. Email is needed to notify Account Holder (with password). 
if(is_null($document_old) && isset($document["system_info"]["email"])){
	$password = bin2hex(openssl_random_pseudo_bytes(8));
	$hash = password_hash($password, PASSWORD_DEFAULT);

// TODO: Change to $setOnInsert
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

