<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description");
//include_once("Auth.php");
include_once("Db.php");
include_once("Output.php");
include_once("Request.php");
include_once("Rules.php");
include_once("Session.php");
include_once("Ownership.php");
include_once("Files.php");
include_once("Logging.php");

class Helper{
	static function curl($base, $path, $params, $auth_head=null, $basic = null){
		// Build Curl Function
		$curl = curl_init();
		$headr = array();
		$headr[] = 'Content-length: 0';
		$headr[] = 'Content-type: application/json';
		if(!is_null($auth_head)){
			if(!is_null($basic) && $basic){
				$headr[] = 'Authorization: Basic '.$auth_head;
			}else{
				$headr[] = 'Authorization: Bearer '.$auth_head;
			}
		}
		curl_setopt($curl, CURLOPT_URL, Helper::buildURL($base, $path, $params));
		curl_setopt($curl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
	       // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$rest = curl_exec($curl);
		// TODO: Check if this works, if not, try a post request with get_file_contents ($context)
		if ($rest === false){ // curl failed
			$out = json_decode(file_get_contents(Helper::buildURL($base, $path, $params)), true);
			$OUTPUT = new Output();
			$OUTPUT->error(2, curl_error($curl));
		}else{
			$out = json_decode($rest, true);
			if(is_null($out) || isset($out["error"])){
				$out = json_decode(file_get_contents(Helper::buildURL($base, $path, $params)), true);
			}
		}
		if(is_null($out) || isset($out["error"])){
			$OUTPUT->error(1, "Unable to retrieve information from API", $out);
		}
		return $out;
	}
	static function buildURL($base, $path, $params){
		/*
		// check if there is an http
			
		// check if href has a domain
		$domain = $_SERVER["HTTP_HOST"];
		$parsed = parse_url($href);
		if(isset($parsed["host"])){
			$domain = $parsed["host"];
		}
		// check if href has a path
		if(isset($parsed["path"])){
			$href = $parsed["path"];
		}
		// check if href has a query
		$concat = "?";
		if(isset($parsed["query"])){
			$href = $href.$parsed["query"];
			$concat = "&";
		}
		// if a new domain was passed- set that
		if(!isset($redom) && !is_null($redom)){
			$domain = $redom;
		}
		// if we need an http:// get that
		if(substr($domain, 0, 4) != "http"){
			$domain = "http://".$domain;
		}
		$url = $domain.$href.$concat."access_token=".$access_token;
		if(filter_var($url, FILTER_VALIDATE_URL)){

		*/
		return $base.$path."?".http_build_query($params);
	}
	static function subDocUpdate($input, $path){
		$update = array();
		foreach($input as $key => $value){
			if(substr($key,0,1) == '$'){
				if(is_array($value)){
					$update[$key] = self::subDocUpdate($value, $path);
				}else{
					$update[$key] = $value;
				}
			}else{
				$update[$path.".".$key] = $value;
			}
		}
		return $update;
	}
	static function updatePermitted($REQUEST, $permitted=array()){
		$update = array();
		if(is_array($permitted) && !empty($permitted)){
			foreach($REQUEST->getParameters() as $key => $value){
				if(in_array($key, $permitted)){
					if(substr($key, -2) == "[]"){
						// this needs to be pushed into the array
						$update['$addToSet'][substr($key, 0, -2)]['$each'] = array_filter(explode(",", $value));
					}else{
						// this can be set manually
						$update['$set'][$key] = $value;
					}
				}
			}
		}else{
			if(is_array($REQUEST->get("update"))){
				if(isset($REQUEST->get("update")['$set'])){
					$update = $REQUEST->get("update");
				}else{
					$update = array('$set' => $REQUEST->get("update"));
				}
				unset($update['$set']["_id"]);
			}else{
				$update = array('$unset' => array($REQUEST->get("update") => "remove")); 
			}
		}
		unset($update["_id"]);
		return $update;
	}
	static function formatQuery($REQUEST, $value_name=null, $key_name=null, $default=null){
		$query = array();
		if(is_null($key_name)){
			$key_name = $value_name;
		}
		if(is_null($value_name)){
			if($REQUEST->avail("query")){
				$query = $REQUEST->get("query");
			}else if($REQUEST->avail("id")){
				if(MongoId::isValid($REQUEST->get("id"))){
					$query = array("_id" => new MongoId($REQUEST->get("id")));
				}else{
					$query = array("_id" => $REQUEST->get("id"));
				}
			}else if($REQUEST->avail("_id")){
				if(MongoId::isValid($REQUEST->get("_id"))){
					$query = array("_id" => new MongoId($REQUEST->get("_id")));
				}else{
					$query = array("_id" => $REQUEST->get("_id"));
				}
			}
		}else if($REQUEST->avail($value_name)){
			if($value_name == "id" || $value_name == "_id"){
				if(MongoId::isValid($REQUEST->get("id"))){
					$query = array("_id" => new MongoId($REQUEST->get("id")));
				}else{
					$query = array("_id" => $REQUEST->get("id"));
				}
			}else{
				if(MongoId::isValid($REQUEST->get($value_name))){
					$query = array($key_name => new MongoId($REQUEST->get($value_name))); 
				}else{
					$query = array($key_name => $REQUEST->get($value_name)); 
				}
			}
		}else{
			if($REQUEST->avail("query")){
				$query = $REQUEST->get("query");
			}else if($REQUEST->avail("id")){
				$query = array("_id" => new MongoId($REQUEST->get("id")));
			}else{
				if(is_null($default)){
					$query = array();
				}else{
					$query = $default;
				}
			}
		}
		return $query;
	}
	static function formatOptions($REQUEST, $options=array()){
		if($REQUEST->avail("remove") && $REQUEST->get("remove") === "true"){
			$options["remove"] = true;
		}
		return $options;
	}
	static function formatLimits($REQUEST, $options=array()){
		if($REQUEST->avail("skip")){
			$options["skip"] = $REQUEST->get("skip");
		}else{
			$options["skip"] = 0;
		}
		if($REQUEST->avail("limit")){
			$options["limit"] = $REQUEST->get("limit");
		}else{
			$options["limit"] = 25;
		}
		return $options;
	}
	static function getCollectionName($REQUEST, $default="Standard", $editable=false){
		if($editable){
			if($REQUEST->avail("collection")){
				return $REQUEST->get("collection");
			}
		}
		return $default;
	}	
}
	
