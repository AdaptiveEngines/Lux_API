<?php
include_once('/var/www/html/Lux/Core/Helper.php');
$OUTPUT = new Output();
$REQUEST = new Request();

$document = array("test1" => "test1", "test2" => "test2", "test3" => "test3");

$OUTPUT->success(0,$document, null);

?>
