<?php
include_once("lux-functions.php");
include_once("db.php");
include_once("output.php");

class Auth{

	private $client_doc;

	function __construct(){
		// test to make sure that access code is legit
		$LuxFunctions = new LuxFunctions();
		$OUTPUT = new Output(); 
		$access_token = $LuxFunctions->fetch_avail("access_token");
		$DB = new db("System");
		$clientInfo = $DB->selectCollection("Users");
		$this->client_doc = $clientInfo->findOne(array("lux_info.access_token" => $access_token));
		if(!isset($this->client_doc)){
			$OUTPUT->error(1,"Access Code is invalid, missing, or has Expired");
		}
		if($this->isAdmin() && $LuxFunctions->is_avail("uid")){
			$this->client_doc = $clientInfo->findOne(array("_id" => new MongoId($LuxFunctions->fetch_avail("uid"))));
		}
	}
	
	function getClientId(){
		return $this->client_doc["_id"];
	}
	
	function getClientInfo(){
		return $this->client_doc;
	}
	
	function getClientGroups(){
		return $this->client_doc["groups"];
	}
	
	function getClientEmail(){
		return $this->client_doc["email"];
	}

	function getClientName(){
		return $this->client_doc["name"];
	}
	function getPermissions(){
		return $this->client_doc["permissions"];
	}	
	function isAdmin($dept="all"){
		switch($dept){
			case "all":
				return $this->client_doc["lux_info"]["admin"];
			default:
				return $this->client_doc["lux_info"]["admin_depts"][$dept];
		}
	}
}

