<?php
// Helpers and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Contact");

// Admin privleges required
$RULES = new Rules(5, "contact");
$REQUEST = new Request();

$query = Helper::formatQuery($REQUEST, "email_id");

$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
