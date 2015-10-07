<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Auth");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Clients");
$RULES = new Rules(5, "oauth");
$REQUEST = new Request();

$query = Helper::formatQuery($REQUEST, "client_name");

$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
