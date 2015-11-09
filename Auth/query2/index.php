<?php
// Helper functions adn includes
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Auth");
$OUTPUT = new Output();
$collection = $db->selectCollection("Providers");

// Admin privleges required
$RULES = new Rules(5, "providers");
$REQUEST = new Request();

// provider name required for query
$query = Helper::formatQuery($REQUEST, "provider_name", null, array("protocol"=>"OAuth2"));
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
