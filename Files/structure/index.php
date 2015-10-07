<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$FILES = new Files();
$REQUEST = new Request();
$OUTPUT = new Output();
if($REQUEST->avail("admin") && $REQUEST->get("admin")){
	$RULES = new Rules(5, "files");
	$structure = $FILES->ls($REQUEST, '/var/www/html'.$REQUEST->get("admin_base", "/"));
}else{
	$RULES = new Rules(0, "files");
	$structure = $FILES->ls($REQUEST, '/var/www/html/uploads/');
}

	$OUTPUT->success(1, $structure);
?>

