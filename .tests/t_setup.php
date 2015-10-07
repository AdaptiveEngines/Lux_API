<?php
include_once('../Core/lux-functions.php');
include_once('../Core/db.php');
include_once('../Core/output.php');

// creates standard classes for the core modules
$LF = new LuxFunctions();
$DB = new db("System");
$OUTPUT = new Output();
$clientInfo = $DB->selectCollection("Users");

if (php_sapi_name() == "cli") {
	$access_token = $_SERVER['argv'][1]; 
	$name = $_SERVER['argv'][2]; 
	$job =  $_SERVER['argv'][3]; 
}else{
	$access_token = $LF->fetch_avail("access_token");
	$name = $LF->fetch_avail("name");
	$job = $LF->fetch_avail("job");
}
$client_doc = $clientInfo->insert(array("name" => $name, "job" => $job, "lux_info" => array("admin" => "true", "access_token" => $access_token)));
$OUTPUT->sucess($client_doc);
?>
