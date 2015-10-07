# Session API

## Access
Access to the API is through the url 

```
/Lux/Session/<api_name>
```

## Dashboard
The Dashboard does not have a Session section, however a test of this API is available in the Session section of the Lux tests. 

/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated Sessoin document"
		}		
		,"params": {
			 "[sid]" : "The session id if one is available"
			,"*":"Any key/value pair that you would like to save into the session"
		}
		,"description":"Sessions can be used regardless of if a user is logged in or not, however a pre-existing session can be recovered if the id is known. This makes sessions useful for storing information between pages that may not be important enough (or finalized) to save in the database. It also makes it possible to move sessions between devices with only a link that includes the sid"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The variable or variables queried for"
		}		
		,"params": {
			 "[sid]" : "The session id if one is available"
			,"[key]" : "The variable you would like to query for. If none is specified then the entire session will be returned"
		}
		,"description":"Query for session variables"
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
}
