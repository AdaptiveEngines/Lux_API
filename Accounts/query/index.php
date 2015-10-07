<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Accounts");
$RULES = new Rules(5, "accounts");
$REQUEST = new Request();

$LOG = new Logging("Accounts.query");
$LOG->log($RULES->getId(), 2, $RULES->getId(),100, "User Account Queried");

$query = Helper::formatQuery($REQUEST, "user", "system_info.user");
$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
