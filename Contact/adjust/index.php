<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("System");
$OUTPUT = new Output();
$collection = $db->selectCollection("Contact");
$RULES = new Rules(5, "contact");
$REQUEST = new Request();

$permitted = array("address[]", "sender");
$update = Helper::updatePermitted($REQUEST, $permitted);

$query = array("email_id" => $REQUEST->get("email_id")); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
