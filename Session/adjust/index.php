<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$db = new Db("Assets");
$OUTPUT = new Output();
$REQUEST = new Request();
if($REQUEST->avail("sid"){
	$SESSION = new Session($REQUEST->get("sid"))
}else{
	$SESSION = new Session();
}
$params = $REQUEST->getParameters();
unset($params["sid"]);
foreach($params as $key => $value){
	$SESSION->set($key, $value);
}

$OUTPUT->success(0,$SESSION->get(), null);

?>
