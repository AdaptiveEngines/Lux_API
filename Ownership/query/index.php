<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$REQUEST = new Request();
$RULES = new Rules(0, "ownership");
$OWNERSHIP = new Ownership($RULES);
$OUTPUT = new Output();

$document = $OWNERSHIP->find($REQUEST);

$OUTPUT->success(1,$document);

?>

  
