<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Notifications");
$REQUEST = new Request();
$RULES = new Rules(1, "social");

$permitted = array("subject", "body", "attachment", "attachment[]");

// to || thread

$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "message");

// if thread id is not set, query for the thread and create a new one if none exists
	// get the thread id
// find the last message on that thread (if one exists)
	// create a document that references the last document and the thread_id

if(!$REQUEST->avail("thread")){
	$doc = $collection->findAndModify(
		array( // query
			 "reciepients" => $REQUEST->get("to")
			,"reciepients" => $RULES->getId()
			,"root" => true
		) 
		,array( // update
			'$setOnInsert' => array( "creator" => $RULES->getId() )
		));
	$thread = $doc["_id"];
}else{
	$thread = $REQUEST->get("thread");
}
$root = $collection->find($thread);
if(is_null($root)){
	$OUTPUT->error(1, "The thread_id provided appears to be invalid");
}

$last = $collection->findOne(
				array(
					 '$query' => array("root" => $thread)
					,'$orderBy' => array( '$natural' => -1)
					
			);
$update["root"] = $thread;
$update["previous"] = $last["_id"];
$new = $collection->insert($update);
$OUTPUT->success(1, $new);
?>

