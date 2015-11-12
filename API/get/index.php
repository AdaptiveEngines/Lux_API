<?php
include_once("/var/www/html/Lux/Core/Helper.php");

$DB = new Db("System");
$OUTPUT = new Output("Auth");
$collection = $DB->selectCollection("Providers");
$REQUEST = new Request();
$RULES = new Rules(0, "api");

$LOG = new Logging("API.get");
$LOG->log($RULES->getId(), 13, $REQUEST->get("provider"),100, "User Queried Provider API");

// Get the call definition from the database
$service = $collection->findOne(array("provider_name"=>$LF->fetch_avail("provider_name")));

// check if the provider is available
if(isset($service)){
	// base_url ? key_name = key
	// example.com?key=siofhsafd
        if(!isset($service["key_name"]) || !isset($service["key"]) || !isset($service["base_url"])){
		$OUTPUT->error(2, "Database is not properly set-up for this service");	
	}

	// the GET parameters of the call
        $call = $LF->fetch_avail("call");

        // check if the first portion of the call has a / -> if so, remove it.
        if(substr($call, 0, 1) === "/"){
                $call = substr($call, 1);
        }
	// do the same check for the base_url
        if(substr($base, -1) === "/"){
                $base = substr($base, 0,-1);
        }

	// if the call already has parameters after it, then just add the key to the end
        if(strpos($call, "?") != FALSE){
                $document = $base."/".$call."&".$service["key_name"]."=".$service["key"];
	// if the call doesn't have any parameters in the GET request, then only add the key to it 
        }else{
                $document = $base."/".$call."?".$service["key_name"]."=".$service["key"];
        }

	// Get the post parameters
	if($LF->is_avail("params")){
		// send the post parameters
		if(is_array($LF->fetch_avail("params"))){
			$postdata = http_build_query($LF->fetch_avail("params"));
		}else{
			$postdata = http_build_query(array($LF->fetch_avail("params")));
		}
	}else{
		$postdata = http_build_query(array());
	}
	// build the HTTP request
	$opts = array('http' =>
	    array(
		'method'  => 'POST',
		'header'  => 'Content-type: application/x-www-form-urlencoded',
		'content' => $postdata
	    )
	);
	// make the HTTP into a "context"
	$context  = stream_context_create($opts);

	// make the actual request in context
	$result = file_get_contents($document, false, $context);

	$OUTPUT->success(1, null, $results);

}else{
        $OUTPUT->error(2, "Service Could not be found");
}

$LF= new LuxFunctions();
$OUTPUT = new Output();
$DB = new Db("System");
$providers = $DB->selectCollection("providers");
$users = $DB->selectCollection("Users");
$provider_name = $LF->fetch_avail("provider");
$user = $users->findOne(array("lux_info.access_token" => $LF->fetch_avail("access_token")));
$access_token = $user["providers"][$provider_name]["access_token"];

$provider = $providers->findOne(array(
	"provider_name"=>$provider_name
));
if(!$LF->is_avail("base")){
	$base = $provider["base4"];
}else{
	$base = $LF->fetch_avail("base");
}

$params = $LF->getParameters();
unset($params["base"]); 
unset($params["provider"]); 
unset($params["path"]); 
$params["access_token"] = $access_token;


$meDoc = json_decode(file_get_contents($base.$LF->fetch_avail("path")."?".http_build_query($params)), true);
if(is_null($meDoc) || isset($meDoc["error"])){
	$meDoc = curl($base.$LF->fetch_avail("path"), $params, $access_token);
}
if(is_null($meDoc) || isset($meDoc["error"])){
	$OUTPUT->error(1, "Unable to retrieve information from API", $meDoc);
}
$OUTPUT->success(1, $meDoc);

  
