<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("System");
$OUTPUT = new Output();
$collection = $db->selectCollection("Content");
$RULES = new Rules(5, "cms");
$REQUEST = new Request();

$permitted = array("content.full", "content.short", "header.text","header.sub", "header.url_safe", "picture.banner", "picture.other[]", "picture.slideshow[]");

$update = Helper::updatePermitted($REQUEST, $permitted);

$LOG = new Logging("CMS.adjust");
$LOG->log($RULES->getId(), 51, $REQUEST->get("field_name"),100, "Content Updated");

$query = array("field_name" => $REQUEST->get("field_name")); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,$document, $results);

?>

  
