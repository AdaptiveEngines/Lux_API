<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$REQUEST = new Request();
$RULES = new Rules(0, "log");
$LOG = new Logging("Log.log");
$LOG->log($RULES->getId(), $REQUEST->get("event"), $REQUEST->get("trigger"),$REQUEST->get("severity", 100),$REQUEST->get("message", ""));

?>
