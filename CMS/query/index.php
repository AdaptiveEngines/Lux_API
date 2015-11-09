<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Content");
$REQUEST = new Request();

$query = Helper::formatQuery($REQUEST, "field_name");

$LOG = new Logging("CMS.query");
$LOG->log($RULES->getId(), 52, $REQUEST->get("field_name"),100, "Content Viewed");

$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
