<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"OAuth1"));
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
