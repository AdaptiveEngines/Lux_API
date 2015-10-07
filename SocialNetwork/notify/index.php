<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Notifications");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$permitted = array("subject", "body", "attachment", "attachment[]");

// to || thread

$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "notification");

// insert a new notification 

$update["to"] = $REQUEST->get("to");

$new = $collection->insert($update);
$OUTPUT->success(1, $new);
?>
