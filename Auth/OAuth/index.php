<?php
include_once("/var/www/html/Lux/Core/Helper.php");
class OAuth{
	private $provider;
	public function OAuth($provider_name, $sId){
		$DB = new Db("Auth");
		$providers = $DB->selectCollection("Providers");
		$this->provider = $providers->findOne(array("provier_name" => $provider_name));
		if(is_null($provider)){
			$OUTPUT->error(2, "Provider is not listed, please visit OAuth Dashboard to register an OAuth2 Provider");
		}
		$SESSION = new Session($sId);
		// set the provider document for use later (no db call)
		$SESSION->set("provider", $provider);
		
		// return the appropriate OAuth Class
		if(isset($this->provider["protocal"])){
			if($this->provider["protocol"] && $this->provider["protocal"] == "OAuth1"){
				return new OAuth1($provider);
			}
		}	
		return new OAuth2($provider);
	}
	public static function redirect($access_token, $sId){
		$SESSION = new Session($sId);
		$href = $SESSION->get("href");
		$redom = $SESSION->get("redom");
		$url = Helper::buildURL($redom, $href, array("access_token"=>$access_token));
		header("Location: $url");
		die();
		echo "Failed to redirect to new page";
	}
}
class OAuth1{
	private $provider;
	public function __construct($provider){
		$this->provider = $provider;
	}	
	public function getURL($sIDd, $scope="email"){

	}
	public function exchange($code, $sId){

	}
	public function save($acces_token, $sId){

	}
}

class OAuth2{
	private $provider;
	public function __construct($provider){
		$this->provider = $provider;
	}

	// Updated to match refactoring
	public function getURL($sId, $scope=null){
		$OUTPUT = new Output();
		$SESSION = new Session($sId);
		// set the provider document for use later (no db call)
		$SESSION->set("provider", $this->provider);
		if($scope == null && isset($this->provider["default_scope"])){
			$scope = $this->provider["default_scope"];
		}else{
			$scope = "email";
		}
		// set the URL parameters
		$base = $this->provider["base1"]; // should end in /authorize or something
		$params = array(
			 "client_id" => $this->provider["client_id"]
			,"redirect_uri" => "http://".$_SERVER["HTTP_HOST"].strtok($_SERVER["REQUEST_URI"], '?') // points to this file
			,"state" => $sId // session id
			,"response_type" => "code"
			,"scope" => $scope
		);
		// build redirect url
		$url = $base."?".http_build_query($params);
		return $url;
	}

	// Updated to support refactoring
	public function exchange($code, $sId){
		$OUTPUT = new Output();
		$SESSION = new Session($sId);
		$provider = $SESSION->get("provider");
		// set the provider document for use later (no db call)
		$base = $provider["base2"]; // should end in /access_token or something
		$params = array(
			 "redirect_uri" => "http://".$_SERVER["HTTP_HOST"].strtok($_SERVER["REQUEST_URI"], '?') // points to this file
			,"code" => $code // code provided by provider
			,"grant_type" => "authorization_code" // always set to this
		);
		$params["client_secret"] = $provider["client_secret"];
		$params["client_id"] = $provider["client_id"];

		$auth_head = base64_encode($provider["client_id"].":".$provider["client_secret"]);
		$AuthObj = Helper::curl($base, $params, $auth_head);
		
		if(!isset($AuthObj) || !isset($AuthObj["access_token"])){
			$OUTPUT->error(2, $AuthObj);
		}
		return $AuthObj["access_token"];
	}


	public function save($access_token, $sId){
		$OUTPUT = new Output();
		$SESSION = new Session($sId);
		$DB1 = new Db("System");
		$System_users = $DB1->selectCollection("Users");
		$DB2 = new Db("SocialNetwork");
		$SN_users = $DB2->selectCollection("Users");	
		$provider = $SESSION->get("provider");

		$base = $provider["base3"];
		$params = array(
			"access_token" => $access_token
		);
		$meDoc = Helper::curl($base, $params, $access_token);

		if(isset($meDoc["id"])){
			$id = $meDoc["id"];
		}else if(isset($meDoc["_id"])){
			$id = $meDoc["_id"];
		}
		$provider_name = $provider["provider_name"];
		$eAT = $SESSION->get("access_token");
		if(!isset($eAT) || is_null($eAT)){
			// generate Lux access_token
			// save into Session
			$lAT = bin2hex(openssl_random_pseudo_bytes(16));
			$SESSION->set("access_token",$lAT);
		}
		// find One where either access_token = access_token or providers.provider_name.id = $meDoc["id"] 
		// update providers.provider_name.access_token = $access_token
		$System_users->update(array('$or'=>array(
			array("providers.$provider_name.id" => $id),
			array("system_info.access_token" => $SESSION->get("access_token"))
		)),
			array( '$set' => array(
					 "system_info.access_token" => $SESSION->get("access_token")
					,"providers.$provider_name.id"=> $id
					,"providers.$provider_name.access_token" => $access_token
				)
				
			), // update
			array("upsert"=>true, "multiple"=>false)
		);
		$AuthDoc = $System_users->findOne(array("system_info.access_token" => $SESSION->get("access_token")));
		$SNDoc1 = array(
			"providers.$provider_name" => $meDoc
		);
		if(!isset($AuthDoc["SN_id"]) || is_null($AuthDoc["SN_id"])){
			// no SN_id exists
			$SNDoc2 = array(
				"providers" => array($provider_name => $meDoc)
			);
			$SN_users->insert($SNDoc2);
			// if no SN_id exists, create a new one
			$System_users->update(
				 array("system_info.access_token" => $SESSION->get("access_token"))
				,array('$set'=>array(
					'SN_id' => $SNDoc2["_id"]
				))
				,array("multiple" => false, "upsert"=>false)
			);
		}else{
			// update providers.provider_name = meDoc where _id = SN_id
			$SN_users->update(
				 array("SN_id" => $AuthDoc["SN_id"])
				,array('$set' => $SNDoc1)
				,array("multiple"=>false, "upsert"=>true)
			);
		}
	}
}

// Logic Code for OAuth 
$REQUEST = new Request();
$OUTPUT = new Output();

// Runs when the request for the redirect url is made
if($REQUEST->avail("provider")){
	// create a new session for this user
	$SESSION = new Session();
	if($REQUEST->avail("access_token")){
		// Save the redirect domain if it is passed in
		$SESSION->set("access_token", $REQUEST->get("access_token"));
	}
	
	// check if the redirect_domain is the same as the HTTP_HOST
	if($REQUEST->avail("redirect_domain")){
		// Save the redirect domain if it is passed in
		$SESSION->set("redom", $REQUEST->get("redirect_domain"));
	}
	// Save the href that you are being redirected to
	if($REQUEST->avail("href")){
		// if an href is passed in
		$SESSION->set("href", $REQUEST->get("href"));
	}else{
		// otherwise, assume the base file
		$SESSION->set("href", "/");
	}

	// get the provider_name and save it
	$SESSION->set("provider_name", $REQUEST->get("provider"));

	$Auth = $OAuth($REQUEST->get("provider"), $SESSION->id());

	// call the redirect function to get the right URL
	echo $Auth->getURL($SESSION->id(), $REQUEST->get("scope"));

// Runs if there is not an error, and the function can continue
// to execute until the redirect
}else if($REQUEST->avail("code") && $REQUEST->avail("state")){
	// get back your session from state
	$SESSION = new Session($REQUEST->get("state"));
	$Auth = $OAuth($SESSION->get("provider")["provider_name"], $SESSION->id());

	$access_token = $Auth->exchange($REQUEST->get("code"), $SESSION->id());
	$Auth->save($access_token, $SESSION->id());
	OAuth::redirect($SESSION->get("access_token"), $SESSION->id());

// runs if there is an error with the Redirect URL
}else if($REQUEST->avail("error")){
	echo $REQUEST->get("error");	

// Runs on a weird unknown error
}else{
	$OUTPUT->error(2, "OAuth Provider is not properly set-up");
}
?>
