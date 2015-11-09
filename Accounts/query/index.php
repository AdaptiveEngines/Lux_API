<?php
// Helper script and includes
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$OUTPUT = new Output();

// Connects to MongoDB
$collection = $DB->selectCollection("Accounts");

// Admin privleges needed
$RULES = new Rules(5, "accounts");
$REQUEST = new Request();

// Used for Analytics
$LOG = new Logging("Accounts.query");
$LOG->log($RULES->getId(), 2, $RULES->getId(),100, "User Account Queried");

// Find and Output list of users.
$query = Helper::formatQuery($REQUEST, "user", "system_info.user");
$document = $collection->find($query);
$OUTPUT->success(0,$document);

?>

  
