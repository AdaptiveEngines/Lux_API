<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$Users = $DB->selectCollection("Users");
$Groups = $DB->selectCollection("Groups");
$REQUEST = new Request();
$RULES = new Rules(0, "social");


// find in user or find in group

// search by term: 
$query = array('$or' => array(
			 "username" => new MongoRegex("/".$REQUEST->get("term")."/i")
			,"name" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"stuff" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"things" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"text" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"spetjiomg" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"adasd" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"nasdafa" =>new MongoRegex("/".$REQUEST->get("term")."/i")
			,"other" =>new MongoRegex("/".$REQUEST->get("term")."/i")
	));

$options = Helper::formatLimits($REQUEST);
$user = $Users->find($query, $options);
$group = $Groups->find($query, $options);

$document = array("users" => $user, "groups" => $groups);

$OUTPUT->success(0, $document);

?>

