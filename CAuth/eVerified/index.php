<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$RULES = new Rules(1);
$OUTPUT = new Output();
$REQUEST = new Request();

if(!is_null($collection->findOne(array("system_info.access_token"=>$REQUEST->get("access_token"), "system_info.eVerified" => true)))){
	$OUTPUT->success(1, "Email is verified in the system");
}else{
	$OUTPUT->error(1, "Email is not verified");
}

