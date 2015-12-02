// require appropriate libraries
//
// socket.io set-up
// 	This does not need an http server, and this model does not use one
var io = require('/usr/lib/node_modules/socket.io')(3000);

// All the requirements for Mongo- although most are not used 
// 	Hence commended out
var Db = require('/usr/lib/node_modules/mongodb').Db;
var MongoClient = require('/usr/lib/node_modules/mongodb').MongoClient;
var MongoServer = require('/usr/lib/node_modules/mongodb').Server;
var ReplSetServers = require('/usr/lib/node_modules/mongodb').ReplSetServers;
var ObjectID = require('/usr/lib/node_modules/mongodb').ObjectID;
var Binary = require('/usr/lib/node_modules/mongodb').Binary;
var Grid = require('/usr/lib/node_modules/mongodb').Grid;
var Code = require('/usr/lib/node_modules/mongodb').Code;
//var BSON = require('/usr/lib/node_modules/mongodb').pure().BSON;

// Declarations for mongo- keeps their scope page-wide
var mongoConnection;
var SN;
var System;



var message;
var online;
var lux;



// Message Class
// 	Sending
// 	and reciepts (delivered/read)
var Message = function(socket){
	this.socket = socket;
	this.update = function(code, data, socket){
		// get data in
		// update message as read by: userId in mongo
		var update = {
			'$addToSet' : {}
		};
		update["$addToSet"][code] = socket.userId;
		SN.collection("Messages").findAndModify(
			// query for message id where group id = data.group
			 {"_id": new ObjectID(data.message_id)} // query
			,[] // sort order
			,update
			,{
				"new" : true
				,"upsert" : true
			} // options
			,function(err, doc){
				if(err != null){ 
					// don't do anything? 
					socket.emit('error', {error: "Database Failed to update", code: 1});
				}else{
					lux.output.group(code, {
						 "userId" : socket.userId
						,"message_id" : data.message_id
					}, data.group_id)
				}
			}
			// update to include this usersId in the seen group
		);
	}
	this.send = function(data, socket){
		SN.collection("Messages").findAndModify(
			// query for message id where group id = data.group
			 {"previous": data.message_id, "root": data.group_id} // query
			,[] // sort order
			,{
				"$set" : {
					 "message.body" : data.message
					,"message.subject" : data.subject
					,"message.attachment":data.attachment
				}
				,"$setOnInsert" : {"creator": socket.userId}
			} // update
			,{
				"new" : true
				,"upsert" : true
			} // options
			,function(err, doc){
				if(err != null){ 
					// don't do anything? 
					socket.emit('error', {error: "Message Failed to send", code: 1, err: err});
				}else{
					lux.output.group('message', doc, data.group_id)
				}
			}
		);
	}
	this.read = function(data, socket){
		this.update("read", data, socket);
	}
	this.recieved = function(data, socket){
		this.update("recieved", data, socket);
	}
}

// Online Class
// 	Overall tracking of user's 
// 	very basic at this point
// 	Add will put user's into rooms they are part of.
var Online = function(){
	this.users = {};
	var _this = this;
	this.add = function(socket){
		_this.users[socket.userId] = {};
		_this.users[socket.userId].socket = socket;
		_this.users[socket.userId].online = true;
		_this.users[socket.userId].connected = new Date();
		console.log("User Connected");
		SN.collection("Groups").find({}//{"members" : socket.userId}
			,function(err, cursor){
				if(err != null){
					lux.output.error(1, "User is not in any groups", socket);
				}else{
					cursor.each(function(err, doc){
						if(err != null){
							lux.output.error(1, "User is not in any groups", socket);
						}else{
							if(doc){
								// add user to each room based on id
								// create room if none exists
								console.log("User Joined Group : " + doc["_id"]);
								socket.join(doc["_id"]);
							}
						}
					});
				}
			});
	}
	this.remove = function(socket){
		if(socket.userId && _this.users[socket.userId]){
			delete _this.users[socket.userId].socket;
			_this.users[socket.userId].online = false;
			_this.users[socket.userId].disconnected = new Date();
			console.log("User Disconnected");
		}
	}
	this.who = function(){
		return Object.keys(online.users);
	}
}




// Lux class
// 	Basic output and lux elements that reflect the HTTP interface
var Lux = function(){
	this.lookup = function(data, callback){
		System.collection("Accounts").findOne({"system_info.access_token" : data.access_token},
		function(err, user){
			if(err != null){
				callback("Invalid access token", null);
			}else{
				console.log("User : " + user["_id"]);
				callback(null, {"userId" : user["_id"]});
			}
		});
	}
	this.output = {
		error : function(code, message, socket){
			socket.emit('error', message);
			socket.disconnect();
			online.remove(socket);
		}
		,success : function(code, results, socket){
			socket.emit(code, results);
		}
		,group : function(code, results, group){
			io.to(group).emit(code, results);
		}
	}
	this.getDb = function(){
		return "ec2-52-25-154-39_us-west-2_compute_amazonaws_com";
	}
}


// Connect to the Mongo Database
// 	Establish any connections to different databases here
var mongoclient = new MongoClient( new MongoServer("localhost", 27017), {native_parser:true});
console.log("Preparing Connection");
mongoclient.connect("mongodb://localhost:27017", function(err, mc){
	if(err != null){
		// error in establishing connection to database
		console.log("Failed to open MongoDB connection");
		console.log(err);
	}else{
		console.log("Connected");
		mongoConnection = mc;
		SN = mc.db( lux.getDb() + "_SocialNetwork"); // need to put in name of chat server databases.
		System = mc.db( lux.getDb() + "_System"); // need to put in name of chat server databases.
	}
});

var message = new Message();
var online = new Online();
var lux = new Lux();

// Socket.io set-up
// 	Does not perform any real logic- just 
// 	catches messages and executes the appropriate function
io.on('connection', function(socket){
		// check user credentials and add to list of user's online
	
	socket.on('error', function(err){
		console.log(err);
	});

	socket.on('register', function(data){
		lux.lookup(data, function(err, result){
			if(err != null){
				lux.output.error(1, err, socket);
			}else{
				socket.userId = result.userId;
				online.add(socket);
			}
		});
	});
	socket.on('disconnect', function(){
		// remove from list on user's online
		online.remove(socket);
	});

	socket.on('read', function(data){
		// mark a single message in the thread as read up until this point. 
		// Notify all thread members of this update
		console.log(data);
		message.read(data, socket);
	});

	socket.on('recieved', function(data){
		// mark a single message in the thread as recieved. 
		// Notify all thread members of this update
		console.log(data);
		message.recieved(data, socket);
	});

	socket.on('typing', function(data){
		// Notify all thread members of this update
		console.log(data);
		lux.output.group('typing', {
			 "userId" : socket.userId
		}, data.group_id);
	});

	socket.on('message', function(data){
		// attach a message to the appropriate thread
		console.log(data);
		message.send(data, socket);
	});

	socket.on('who', function(data){
		// return all userIDs of users online
		console.log(data);
		socket.emit('who', online.who());
	});

});
