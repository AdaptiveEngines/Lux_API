function TestCall(name, URL, data, callback){
	var request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		if(request.readyState == 4 && request.status == 200){
			var placement = document.createElement("DIV");	
			placement.innerHTML = "<br/>"+name+" : ";
			try{
				var response = JSON.parse(request.responseText);
				if(response.status.code == 1 && callback(response)){
					placement.innerHTML += "<div style='color:green'><pre>"+JSON.stringify(response, null, '\t')+"</pre></div><br/>";
				}else if(response.status.code == 0){
					placement.innerHTML += "<div style='color:red'><pre>"+JSON.stringify(response, null, '\t')+"</pre></div><br/>";
				}else{
					placement.innerHTML += "'<pre>" + JSON.stringify(response.status.code, null, '\t') +"' </pre><div style='color:#DDAF00'><pre>"+JSON.stringify(response, null, '\t')+"</pre></div><br/>";
				}
			}catch(err){
				console.log("Can't Parse " + name + " because " + err);
				if(request.responseText.match(/on\sline/i)){
					placement.innerHTML += "<div style='color:red'>"+request.responseText+"</div><br/>";
				}else{
					placement.innerHTML += "<div>"+request.responseText+"</div><br/>";
				}
			}
			document.body.appendChild(placement);
		}
	}
	request.open("POST",URL+"?access_token="+url.access_token,true);
	request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	request.send(JSON.stringify(data));
}
function Test(name, URL, data, callback){
	if(data === undefined){
		console.log(name + " has an undefined data field");
		data = {};
	}
	if(callback === undefined){
		console.log(name + " has an undefined callback field");
		TestCall(name, URL, data, function(){
			return true;
		});
	}else{
		TestCall(name, URL, data, callback);
	}
}

function getJsonFromUrl(){
	console.log("getJsonFromURL");
	var query = location.search.substr(1);
	var result = {};
	query.split("&").forEach(function(part) {
		var item = part.split("=");
		result[item[0]] = decodeURIComponent(item[1]);
	});
	return result;
}
var url = getJsonFromUrl();

function DashboardCall(name, URL, URL2, data, callback){
	var request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		if(request.readyState == 4 && request.status == 200){
			var placement = document.createElement("DIV");	
			placement.innerHTML = name+" : <br/>";
			try{
				var response = JSON.parse(request.responseText).data;
				for(var key in response){
					if(response.hasOwnProperty(key)){
						for(var key2 in response[key]){
							if(response[key].hasOwnProperty(key2)){
								placement.innerHTML += 
									"<label>"+key2+"</label>"+
									"<input onblur='adjust(this, \""+URL2.toString()+"\")' "+
									"class='"+key+"' value='"+response[key][key2]+"'/><br/>";
							}		
						}
						placement.innerHTML += "<br/><hr/><br/>";
					}
				}
			}catch(err){
				console.log("Can't Parse " + name + " because " + err);
				if(request.responseText.match(/on\sline/i)){
					placement.innerHTML += "<div style='color:red'>"+request.responseText+"</div><br/>";
				}else{
					placement.innerHTML += "<div>"+request.responseText+"</div><br/>";
				}
			}
			document.body.appendChild(placement);
		}
	}
	request.open("POST",URL+"?access_token="+url.access_token,true);
	request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	request.send(JSON.stringify(data));
}
function adjust(element, URL){
	console.log("Blurred");
	var elements = document.getElementsByClassName(element.className);
	var data = {};
	for(var key in elements){
		if(elements.hasOwnProperty(key)){
			data[elements[key].previousSibling.innerText] = elements[key].value;
		}
	}	
	Test("Adjusted", URL, data);
}
function Dashboard(name, URL, URL2, data, callback){
	if(data === undefined){
		console.log(name + " has an undefined data field");
		data = {};
	}
	if(callback === undefined){
		console.log(name + " has an undefined callback field");
		DashboardCall(name, URL, URL2, data, function(){
			return true;
		});
	}else{
		DashboardCall(name, URL, URL2, data, callback);
	}
}

