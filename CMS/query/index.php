<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Content");
$REQUEST = new Request();

$query = Helper::formatQuery($REQUEST, "field_name");

$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
