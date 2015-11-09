<?php
// helper and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");

// Admin Privleges required
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

// provider name required for specific query (otherwise all will be returned)
$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"OAuth1"));
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
