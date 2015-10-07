<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("System");
$OUTPUT = new Output();
$collection = $db->selectCollection("Contact");
$REQUEST = new Request();

$query = array("email_id" => $REQUEST->get("email_id")); 
$document = $collection->findOne($query);


$to = trim(implode(" , ", $document["address"]), ' , ');
$subject = $REQUEST->get("subject");
$message = $REQUEST->get("body");


$sender = $REQUEST->avail("sender") ? $REQUEST->get("sender") : ($document["sender"]? $document["sender"] : "noreply@".$_SERVER["HTTP_HOST"]);

$headers = 'From: '.$sender . "\r\n" .
           'Reply-To: '. $sender . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

$result = mail($to, $subject, $message, $headers);

if($result == 1){
	$OUTPUT->success(0,null, null);
}else{
	$OUTPUT->error(2,"An Error occured in the mail function");
}

?>

  
