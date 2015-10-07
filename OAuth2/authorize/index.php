<?php
include_once('/var/www/html/Lux/Core/Helper.php');

$DB = new Db("Auth");
$OUTPUT = new Output();
$collection = $DB->selectCollection("Clients");
$REQUEST = new Request();
// client_id	redirect_uri	state	response_type:code scope

$client_id = $REQUEST->get("client_id");
$redirect_uri = $REQUEST->get("redirect_uri");
$client_doc = $collection->findOne(array("client_id" => $client_id
					,"redirect_uri" => array(
							'$elemMatch' => array( '$in' => array($redirect_uri))
					)
				));
if($REQUEST->get("response_type") != "code"){
	echo "The response_type must be set to 'code' for this OAuth system";
	die();
}
if(is_null($client_doc)){
	echo "An error occured, this client does not appear in the database, or the redirect URI does not match";
	die();
}
if($REQUEST->avail("state")){
	$state = $REQUEST->get("state");
	$location = "$redirect_uri?state=$state&code=";
}else{
	$location = "$redirect_uri?code=";
}
?>
<html>
<head>	
	<script>
		function Ajax(URL, data, callback){
			var request = new XMLHttpRequest();
			request.onreadystatechange=function(){
				try{
					var response = JSON.parse(request.responseText);
					callback(response);
				}catch(err){
					console.log("Can't Parse " + name + " because " + err);
					console.log(request.responseText);
				}
			}
			request.open("POST",URL,true);
			request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
			request.send(JSON.stringify(data));
		}

		function submit(){
			var user = document.getElementById("username").value;
			var pass = document.getElementById("password").value;
			
			Ajax("../CAuth/authorize/", 
				{"user":user, "password":pass, "response_type":"code", "client_id": "<?= $client_id ?>"}, 
				function(response){
					if(response.hasOwnProperty("data")){
						window.location = "<?= $location ?>"+response.data.code;
					}else{
						if(response.hasOwnProperty("error")){
							document.getElementById("message").innerHTML = response.status.message;
						}else{
							document.getElementById("message").innerHTML = "Something is messed up";
						}
					}	
				});	
		}
	</script>
</head>
<body>
	<label>username/email : </label><input id="username"/>
	<label>password       : </label><input type="password" id="password"/>
	<button onclick="submit()">Submit</button>
	<div id="message"></div>
</body>
</html>
