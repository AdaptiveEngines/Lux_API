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



// Message Class
// 	Sending
// 	and reciepts (delivered/read)
var Message = function(socket){
	this.socket = socket;
	this.update = function(code, data){
		// get data in
		// update message as read by: userId in mongo
		SN.collection("Messages").findAndModify(
			// query for message id where group id = data.group
			 {"_id": data.message_id, "root": data.group_id} // query
			,[] // sort order
			,{'$addToSet' : {code: socket.userId}} // update
			,{} // options
			,function(err, doc){
				if(err != null){ 
					// don't do anything? 
					socket.emit('error', {error: "Database Failed to update", code: 1});
				}else{
					lux.output.group(code, {
						 "userId" : userId
						,"message_id" : data.message_id
					}, data.group)
				}
			}
			// update to include this usersId in the seen group
		);
	}
	this.send = function(){
		SN.collection("Messages").findAndModify(
			// query for message id where group id = data.group
			 {"previous": data.message_id, "root": data.group_id} // query
			,[] // sort order
			,{
				 "message.body" : data.message
				,"message.subject" : data.subject
				,"message.attachment":data.attachment
				,"$setOnInsert" : {"creator": socket.userId}
			} // update
			,{} // options
			,function(err, doc){
				if(err != null){ 
					// don't do anything? 
					socket.emit('error', {error: "Message Failed to send", code: 1});
				}else{
					lux.output.group('message', doc, data.group)
				}
			}
		);
	}
	this.read = function(data){
		this.update("read", data);
	}
	this.recieved = function(data){
		this.update("recieved", data);
	}
}


// Online Class
// 	Overall tracking of user's 
// 	very basic at this point
// 	Add will put user's into rooms they are part of.
var Online = function(){
	this.users = {};
	this.remove = function(socket){
		delete users[socket.userId].socket;
		users[socket.userId].online = false;
		users[socket.userId].disconnected = new Date();
	}
	this.add = function(socket){
		users[socket.userId].socket = socket;
		users[socket.userId].online = true;
		users[socket.userId].connected = new Date();
		SN.collection("Groups").find({"members" : socket.userId}
				,function(err, cursor){
					if(err != null){
						lux.output.error(1, "User is not in any groups", socket);
					}else{
						cursor.each(function(err, doc){
							if(err != null){
								lux.output.error(1, "User is not in any groups", socket);
							}else{
								// add user to each room based on id
								// create room if none exists
								socket.join(doc["_id"]);
							}
						});
					}
				});
	}
	this.who = function(){
		return Object.keys(users);
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

var online = new Online();
var lux = new Lux();



// Connect to the Mongo Database
// 	Establish any connections to different databases here
var mongoclient = new MongoClient( new MongoServer("localhost", 27017), {native_parser:true});
mongoclient.connect(function(err, mc){
	if(err != null){
		// error in establishing connection to database
		console.log("Failed to open MongoDB connection" + err);
	}else{
		mongoConnection = mc;
		SN = mc.db( lux.getDb() +"_SocialNetwork"); // need to put in name of chat server databases.
		System = mc.db( lux.getdDb() +"_System"); // need to put in name of chat server databases.
	}
	
});


// Socket.io set-up
// 	Does not perform any real logic- just 
// 	catches messages and executes the appropriate function
io.on('connection', function(socket){
		// check user credentials and add to list of user's online
	
	var message = new Messages();


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
		message.read(data);
	});

	socket.on('recieved', function(data){
		// mark a single message in the thread as recieved. 
		// Notify all thread members of this update
		message.recieved(data);
	});

	socket.on('typing', function(data){
		// Notify all thread members of this update
		lux.output.group('typing', {
			 "userId" : socket.userId
		}, data.group);
	});

	socket.on('message', function(data){
		// attach a message to the appropriate thread
		messsage.send(data);
	});

	socket.on('who', function(data){
		// return all userIDs of users online
		socket.emit('who', online.who());
	});

});
