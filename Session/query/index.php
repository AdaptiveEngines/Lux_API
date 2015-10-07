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
if($REQUEST->avail("key")){
	$OUTPUT->success(1,$SESSION->get($REQUEST->get("key")));
}else{
	$OUTPUT->success(1,$SESSION->get());
}

?>

  
