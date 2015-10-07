<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("SocialNetwork");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Connections");
$Users = $DB->selectCollection("Users");
$Groups = $DB->selectCollection("Groups");
$REQUEST = new Request();
$RULES = new Rules(1, "social");


// find in user or find in group
$query = $REQUEST->get("id");
$user = $Users->find($query);
if(is_null($user)){
	$user = $Groups->find($query);
	if(is_null($user)){
		$OUTPUT->error(1, "Could not find the specified User or Group");
	}else{
		// create dbRef
		$user2 = MongoDBRef::create("Groups", $query, "SocialNetwork");
	}
}else{
	$user2 = MongoDBRef::create("Users", $query, "SocialNetwork");
}
$user1 = MongoDBRef::create("Users", $RULES->getId(), "SocialNetwork");



// format update
$permitted = array("description", "connection_type");

$update = Helper::updatePermitted($REQUEST, $permitted);
$update = Helper::subDocUpdate($update, "information");


$subQuery1 = array('requestor' => $user1, 'requestee' => $user2);
$subQuery2 = array('requestor' => $user2, 'requestee' => $user1);
$query = array('$or'=> array($subQuery1, $subQuery2));
$document_old = $collection->findOne($query);
if(is_null($document_old)){
	// there is no existing document
	$query = $subQuery1;
	$update["status"]["pending"] = 1;
	$update["status"]["active"] = 0;
}else{
	// there is an existing document
	if($old_document["requestor"] == $user2){
		$query = $subQuery2;	
		$update["status"]["pending"] = 0;
		$update["status"]["active"] = 1;
	}else{
		$OUTPUT->error(1, "Request is pending");
	}
}
// Handle Blocking and stuff
if($REQUEST->avail("block")){
	$update["status"]["blocked"][$RULES->getId()] = 1;
	$update["status"]["active"] = 0;
	$update["status"]["pending"] = 0;
}
if($REQUEST->avail("unblock")){
	$update["status"]["blocked"][$RULES->getId()] = 0;
	$update["status"]["active"] = 0;
	$update["status"]["pending"] = 0;
}
if($REQUEST->avail("remove")){
	$update["status"]["active"] = 0;
	$update["status"]["pending"] = 0;
}
$document = $collection->update($query, $update);
$OUTPUT->success(0, $document);

?>

