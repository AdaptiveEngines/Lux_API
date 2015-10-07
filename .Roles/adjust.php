<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("System");
$collection = $DB->selectCollection("Accounts");
$OUTPUT = new Output();
$REQUEST = new Request();

if($REQUEST->avail("system_info.role")){
	$value = intval($REQUEST->get("system_info.role"));
	if($value > 6){
		$OUTPUT->error(2, "Rule must be less than 6");
	}
	$RULES = new Rules($value);
}
if($REQUEST->avail("system_info.permissions[]")){
	$RULES = new Rules(5);
}

$permitted = array("system_info.role", "system_info.permissions[]");
$update = Helper::updatePermitted($REQUEST, $permitted);

$query = $REQUEST->get("id"); 
$results = $collection->update($query, $update);
$document = $collection->findOne($query);
$OUTPUT->success(0,null, $results);

?>

  
