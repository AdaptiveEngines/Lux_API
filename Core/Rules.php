<?php
include_once("Request.php");
include_once("Output.php");
include_once("Db.php");

class Rules{

	private $client_doc;
	private $role;
	private $permissions;

	function __construct($rule = 0, $permission = null){
		// test to make sure that access code is legit
		$REQUEST = new Request();
		$OUTPUT = new Output(); 
		if($REQUEST->avail("access_token")){
			$access_token = $REQUEST->get("access_token");
			$DB = new db("System");
			$clientInfo = $DB->selectCollection("Accounts");
			$this->client_doc = $clientInfo->findOne(array("system_info.access_token" => $access_token));
			if($rule > 0 && !isset($this->client_doc)){
				$OUTPUT->error(1,"Access Code is invalid, missing, or has Expired");
			}
			if(isset($this->client_doc["system_info"]["role"])){
				$this->role = $this->client_doc["system_info"]["role"];
			}	
			if(isset($this->client_doc["system_info"]["permissions"]) && is_array($this->client_doc["system_info"]["permissions"])){
				$this->permissions = $this->client_doc["system_info"]["permissions"];
			}	
			// if the clients role is less than the rule for this file			
			$this->permission($rule, $permission);
		}else if($rule > 0){
				$OUTPUT->error(1,"Access Code is invalid, missing, or has Expired");
		}
	}
	private function permission($rule = 0, $permission = null){
		$OUTPUT = new Output(); 
		if($rule > 1 && $this->role < $rule){
			// Something About the logic here is not working.
			if(!is_null($permission) && is_array($this->permissions)){
				if(!in_array($permission, $this->permissions)){
					$OUTPUT->error(1,"Insufficient Priveleges");
				}
			}else{
				$OUTPUT->error(1,"Insufficient Priveleges");
			}
		}
	}	
	function getId(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return $this->getIP(); } 
		return $this->client_doc["_id"];
	}
	
	function getInfo(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->client_doc;
	}
	
	function getClientGroups(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->client_doc["groups"];
	}
	
	function getEmail(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->client_doc["values"]["email"];
	}

	function getName(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->client_doc["values"]["name"];
	}
	function getPermissions(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->permissions;
	}	
	function getRole(){
		if(!isset($this->client_doc) || is_null($this->client_doc)){ return null; } 
		return $this->role;
	}	
	function getIP() {
	    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
	    foreach ($ip_keys as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
		    foreach (explode(',', $_SERVER[$key]) as $ip) {
			// trim for safety measures
			$ip = trim($ip);
			// attempt to validate IP
			if (validate_ip($ip)) {
			    return $ip;
			}
		    }
		}
	    }
	    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	}
	function validate_ip($ip){
	    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
		return false;
	    }
	    return true;
	}
}


