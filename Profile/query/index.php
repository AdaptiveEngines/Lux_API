<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("SocialNetwork");
$OUTPUT = new Output();
$REQUEST = new Request();
$collection = $db->selectCollection("Users");
$RULES = new Rules(0, "profile");

$query = Helper::formatQuery($REQUEST);
$document = $collection->find($query);

$OUTPUT->success(1,$document);

?>

  
