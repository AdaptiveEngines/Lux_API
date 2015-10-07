<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Users");
$OUTPUT = new Output();
$REQUEST = new Request();
if($REQUEST->avail("rule") && $REQUEST->avail("permissions")){
	$RULES = new Rules($REQUEST->get("rule"), $REQUEST->get("permissions"));
}else if($REQUEST->avail("rule")){
	$RULES = new Rules($REQUEST->get("rule"));
}else{
	$RULES = new Rules(1);
}
$OUTPUT->success(4, array("message" => "Access Permitted"));
