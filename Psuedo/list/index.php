<?php
include_once('/var/www/html/Lux/Core/Helper.php');
$OUTPUT = new Output();
$REQUEST = new Request();

$document[] = array("test11" => "test1.1", "test12" => "test1.2", "test13" => "test1.3");
$document[] = array("test21" => "test2.1", "test22" => "test2.2", "test23" => "test2.3");
$document[] = array("test31" => "test3.1", "test32" => "test3.2", "test33" => "test3.3");
$document[] = array("test41" => "test4.1", "test42" => "test4.2", "test43" => "test4.3");
$document[] = array("test51" => "test5.1", "test52" => "test5.2", "test53" => "test5.3");

$OUTPUT->success(0,$document, null);

?>
