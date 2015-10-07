<?php
include_once('/var/www/html/Lux/Core/Helper.php');
$OUTPUT = new Output();
$REQUEST = new Request();

$document = $REQUEST->getParameters();

$OUTPUT->success(0,$document, null);

?>
