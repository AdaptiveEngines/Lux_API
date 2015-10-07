<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$OUTPUT = new Output();
$REQUEST = new Request();

if(is_null($collection->findOne(array("system_info.user"=>$REQUEST->get("user"))))){
	$OUTPUT->success(1, array("status" => "Username is free in the system"));
}else{
	$OUTPUT->error(1, "User exists with this Username");
}

