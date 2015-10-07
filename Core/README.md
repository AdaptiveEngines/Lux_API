# Core Functions 
The core functions of lux can not be called directly, but are used by almost every other lux API call. This page acts only as a reference for Lux developers, but provides useful knowledge for anyone building on top of Lux. 

The classes within the Lux Core functions include:

* Db
* Helper - static
* Output
* Request
* Rules
* Session 

## Access
Helper is the only static function, all others must be instantiated before use. When building a Lux script you should include the line 

```
include_once('/var/www/html/Lux/Core/Helper.php');
```

which will in turn include all of the other Core classes. Instantiating the other core classes however is still left to the developer. 

## Dashboard
The Dashboard contains to reference to the Core functions directly, however if any core functionality is not working, there will be errors on the Lux requests. 

/*&#x3b1*/
{
	 "Helper::curl()":{
		 "return": {
			 "out" : "The contents of the requested page, encoded as a JSON object."
		}
		,"params": {
			 "base":"The base of the url or the domain"
			,"path":"The file path of the url"
			,"params":"The parameters you wish to pass to the request"
			,"[auth_head]":"The Authorization header for the request"
			,"[basic]":"Determines if the auth_head is in Basic or Bearer format"
		}
		,"description":"Creates a curl request to pull information off of another server. If the curl request is unsuccessful, this method will fall back on a simple get request using `file_get_contents()`"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":["OUTPUT()"]
	}
	,"Helper::buildURL()":{
		 "params": {
			 "base":"The base of the url or the domain"
			,"path":"The file path of the url"
			,"params":"The parameters you wish to pass to the request"
		}
		,"return": {
			"url" : "The URL that has been built from the inputs"
		}
		,"description":"Builds a properly formatted URL from the input parameters"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":["OUTPUT()"]
	
	}
	,"Helper::updatePermitted":{
		 "params": {
			 "REQUEST" : "The Request variable that has been created"
			,"[permitted]":"An array of permitted variables, where array variables end in '[]'"
		}
		,"return":{ 
			"update":"The update to be used in a database call"
		}
		,"description":"Creates an update array which can be used to update the database in a function where only a small number of items are permitted, but no processing is occuring on those items \n\n If the set of values that can be set is not specified (no permitted variable), then an 'update' variable must be specified in the request. This variable will be used to run a '$set' action on the database to modify the fields given. If the update field is not an array, and is instead just the name of a field- then an '$unset' operation will be run on the database to remove that field. If no permitted variable is passed in, and the request does not contain an update, then an error will be thrown."
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Helper::formatQuery()":{
		 "return": {
			 "query" : "A Query object that can be passed to the collection class"
		}
		,"params": {
			 "REQUEST":"The Request variable"
			,"value_name":"The possible value to use during the query"
		}
		,"description":"Takes a variable and formats it into a query if available, otherwise will return an empty query \n\n if the field that is being used as an identifier (value_name) is equal to id, then the value will be formatted as a mongo id before being returned as the query"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"new Db()":{
		 "params": {
			 "Db_name":"The name of the Mongo Database you would like to connect to"
		}
		,"return":{ 
		}
		,"description":"Connects to a Mongo Database, provides basic functionality of using an connecting to a mongo database"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"Db->selectCollection()":{
		 "params": {
			 "Collection_name":"The name of the collection you would like to connect to"
		}
		,"return":{ 
			"collection":"The Collection object to perform operations on"
		}
		,"description":""
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Collection()":{
		 "params": {
			 "db":"The database object"
			,"collection name":"The Collection name you would like to connect to"
		}
		,"return":{ 
		}
		,"description":"Connects to a collection so that other functions can be run on that collection"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->queryFix()":{
		 "params": {
			 "query":"The query you would like to fix"
		}
		,"return":{ 
			"query":"the corrected query"
		}
		,"description":"If an id is passed in, this will turn it into an array for querying"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->resolve()":{
		 "params": {
			 "document":"THe document you would like to resolve"
			,"options":"an options array that specifies that resolve is true"
		}
		,"return":{ 
			"document":"the resolve document"
		}
		,"description":"Finds any dbRefs and replaces them with the associated document"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->findOne()":{
		 "params": {
			 "query":"The query you would like to find"
			,"fields":"The fields you would like returned"
			,"options":"the options array associated with this query"
		}
		,"return":{ 
			"doc":"The document that has been acquired"
		}
		,"description":"Finds a single (or first matching) document in the database"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->find()":{
		 "params": {
			 "query":"The query you would like to run"
			,"options":"The options associated with this query"
		}
		,"return":{ 
			"documents":"an array of documents that were found"
		}
		,"description":"Finds multiple documents in the Mongo Database"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->count()":{
		 "params": {
			 "query":"The query that you would like to make"
		}
		,"return":{ 
			"num":"number of documents matching this query"
		}
		,"description":"Counts the number of documents matching a query"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->update()":{
		 "params": {
			 "query":"The query you would like to update"
			,"update":"The update you would like to apply to all matching documentns"
			,"options":"The mongo db options you would like to apply to all matching documents"
		}
		,"return":{ 
			"results":"The results of the update query"
		}
		,"description":""
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->findAndModify()":{
		 "params": {
			 "query":"The query you would like to update"
			,"update":"The update you would like to apply to all matching documentns"
			,"options":"an array of options, the available options are remove and sort"
		}
		,"return":{ 
			"results":"The modified document"
		}
		,"description":""
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Collection->insert()":{
		 "params": {
			 "update":"The new document you would like to insert"
			,"options":"the options associated with this insert"
		}
		,"return":{ 
			"results":"The results of the insert query"
		}
		,"description":""
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Output()":{
		 "params": {
		}
		,"return":{ 
		}
		,"description":"Builds a new output message, outputs the messages as JSON objects for the client to read. Any success or failure results in the termination of the script."
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Output->getLog()":{
		 "params": {
			 "client":"$REQUEST->getId()"
			,"event":"The event that is being triggered"
			,"trigger":"The trigger that caused this event"
			,"severity":"Level of severity on the request, ranging from -100 to 100"
			,"message":"Any extra detail message that should be included"
			,"API":"The API that calls this event"
		}
		,"return":{ 
			 "log" : "The log object that needs to be stored in the database"
		}
		,"description":"Creates a log document that can be saved into mongo"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Output->success()":{
		 "params": {
			 "code":"\n0. update \n1. query \n2. remove\n3. other\n"
			,"data":"the array of data that has been found"
			,"results":"the results of a mongo update"
		}
		,"return":{ 
		}
		,"description":"Outputs a success object"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Output->error()":{
		 "params": {
			 "code":"\n0. Missing Parameter \n1. Invalid Access Token \n2. Invalid Use of API call \n3. Permission Level Denied \n4. Unknown or uncategorized error"
			,"message":"The message of why an error occured"
		}
		,"return":{ 
		}
		,"description":"Outputs an error to the client"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Request()":{
		 "params": {
		}
		,"return":{ 
		}
		,"description":"Gets all of the Request variables and compiles them into a single array that can be queried. This also includes arguements passed into the command line, and session variables if one exists."
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->getParameters()":{
		 "params": {
		}
		,"return":{ 
			"parameters":"An array of all of the Request vairables "
		}
		,"description":"Returns an array of all of the Request variables"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"[Request->setArray()]":{
		 "params": {
		}
		,"return":{ 
		}
		,"description":"Set's the array. This is the main functionality of the constructor"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->setDocument()":{
		 "params": {
			 "doc":"A new array of values"
		}
		,"return":{ 
		}
		,"description":"Adds any new array to the parameters considered part of the request"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->avail()":{
		 "params": {
			 "var":"The name of the value you would like to check for"
		}
		,"return":{ 
			"boolean":"If the variable is present or not"
		}
		,"description":""
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->get()":{
		 "params": {
			 "var":"The name of the variable you would like to retrieve"
		}
		,"return":{ 
			"value":"The value of the variable you would like to retrieve"
		}
		,"description":"Retrieves a value, forces an error if the value is not set"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->is_get()":{
		 "params": {
			 "var":"Name of the variable you would like to check"
			,"die":"Boolean to see if the program should throw an error or not"
		}
		,"return":{ 
			"boolean":"returns true if variable exists"
		}
		,"description":"Checks if the given variable is a Get request"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Request->is_post()":{
		 "params": {
			 "var":"Name of the variable you would like to check"
			,"die":"Boolean to see if the program should throw an error or not"
		}
		,"return":{ 
			"boolean":"returns true if variable exists"
		}
		,"description":"Checks if the given variable is a Post request"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Rules()":{
		 "params": {
			 "rule":"The rule on the script being executed"
			,"permission":"The permission name on the script being executed"
		}
		,"return":{ 
		}
		,"description":"Checks that the user's role and permissions meet requirements"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"[Rules->permission()]":{
		 "params": {
			 "rule":"The rule you would like to check"
			,"permission":"The permissions you would like to check"
		}
		,"return":{ 
		}
		,"description":"Checks the User's permissions and throws an error if they are insufficient"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getId()":{
		 "params": {
		}
		,"return":{ 
			"id":"User's id"
		}
		,"description":"returns the user's id"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getInfo()":{
		 "params": {
		}
		,"return":{ 
			"doc":"returns the user's document"
		}
		,"description":"Returns the user's document"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getClientGroups()":{
		 "params": {
		}
		,"return":{ 
			"Groups":"The user's groups"
		}
		,"description":"Returns the User's groups"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getEmail()":{
		 "params": {
		}
		,"return":{ 
			"email":"The user's primary email address"
		}
		,"description":"Returns the User's primary email address"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getName()":{
		 "params": {
		}
		,"return":{ 
			"Name":"The User's registered name"
		}
		,"description":"Returns the User's registered name"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getPermissions()":{
		 "params": {
		}
		,"return":{ 
			"permissions":"An array of the user's permissions"
		}
		,"description":"Returns an array of the user's permissions"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Rules->getRole()":{
		 "params": {
		}
		,"return":{ 
			"Role":"The user's role"
		}
		,"description":"Returns the user's role"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Session()":{
		 "params": {
			 "[id]":"The session id that has been passed to the script in some way"
		}
		,"return":{ 
			"session":"The newly created Session"
		}
		,"description":"Creates a new session or resurects an existing session"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":["OUTPUT()"]

	}
	,"Session->id()":{
		 "params": {
		}
		,"return":{ 
			"id":"The current sessions id"
		}
		,"description":"Returns the current sessions id"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Session->get()":{
		 "params": {
			 "key":"The key of the variable you would like to retrieve"
		}
		,"return":{ 
			"value":"The value of that key"
		}
		,"description":"Gets a session variable from the session"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Session->set()":{
		 "params": {
			 "key":"The Key you would like to set"
			,"value":"The value of that key"
		}
		,"return":{ 
		}
		,"description":"Set a parameter in the session variable"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	
	}
	,"[Session->valid_id()]":{
		 "params": {
			 "id":"The session id you would like to check"
		}
		,"return":{ 
			"boolean":"If the session id is valid"
		}
		,"description":"Check if a session id is formatted correctly"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"[Session->session_active()]":{
		 "params": {
		}
		,"return":{ 
			"boolean":"If the session is currently active or not"
		}
		,"description":"Finds out if the session currently is active"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"new Ownership()":{
		 "params": {
			"RULES":"The Rules variable"
		}
		,"return":{ 
		}
		,"description":"Creates a new object of Ownership type. Ownership checks the Assets one by one and determines if their ownership document matches the documents that already exist. If the document does not previously exist in the Ownership collection, a new entry can be made. In circumstances where findAndModify is used, the document will be queried before"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::query()":{
		 "params": {
			"documents":"Document or documents being queried for"
		}
		,"return":{ 
			"documents":"Documents that can be viewed by this user"
		}
		,"description":"Loops through the document(s) and checks who has access/permissions on the document. unsets any documents that can not be viewed. If only one document is present, an error is thrown"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::adjust()":{
		 "params": {
		 	 "collection":"The name of the collection being accessed"
			,"query":"The query being used"
		}
		,"return":{ 
			"query":"A new query that only finds documents that the user has permission to edit"
		}
		,"description":"Since most instances only allow for one document to be edited at a time, the adjust will allow documents to either pass or fail the test. If they fail, then an error is thrown- otherwise, nothing happens. If mulitple documents are found, then they are iterated across and a query is returned that can be used instead"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::id()":{
		 "params": {
			"id":"The id for a document"
		}
		,"return":{ 
		}
		,"description":"Looks up a single document and throws an error if the user does not have write permissions for this document"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::check()":{
		 "params": {
			"docs":"The list of documents that have been created or found"
		}
		,"return":{ 
		}
		,"description":"Finds the documents and sees if they have been previously approved- if they have not then it assumes this person has created them, and makes them the document creator/owner"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::grant()":{
		 "params": {
			"REQUEST":"The Request that has been made to the ownership database"
		}
		,"return":{ 
		}
		,"description":"Grants the specified permissions to the user if the user calling has the correct permissions"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::find()":{
		 "params": {
			"REQUEST":"The Request that has been made to the ownership database"
		}
		,"return":{ 
			"document":"The ownership document for that asset or the Owner's for a number of assets"
		}
		,"description":"Queries for who has permissions on a given document"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"Ownership::mine()":{
		 "params": {
			"REQUEST":"The Request that has been made to the ownership database"
		}
		,"return":{ 
			"document":"The ownership document for that asset or the Owner's for a number of assets"
		}
		,"description":"Queries for what documents a user owns"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"new Logging()":{
		 "params": {
			 "API":"The name of the script being executed"
		}
		,"return":{ 
		}
		,"description":"Creates an object of the Logging API"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"Logging->log()":{
		 "params": {
			 "client":"$REQUEST->getId()"
			,"event":"The event that is being triggered"
			,"trigger":"The trigger that caused this event"
			,"severity":"Level of severity on the request, ranging from -100 to 100"
			,"message":"Any extra detail message that should be included"
		}
		,"return":{ 
		}
		,"description":"Checks that the user's role and permissions meet requirements"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
	,"[Logging->addToDb()]":{
		 "params": {
			 "log":"The log being added to the database"
		}
		,"return":{ 
		}
		,"description":"Adds the log to the appropriate database"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]

	}
}
