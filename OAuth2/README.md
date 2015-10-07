# External OAuth2 Access Gateway
The OAuth2 system is an authorization system for external or third party clients to authorize their application using your user's login. Clients can create an account and recieve a client\_id and client\_secret, however the dashboard for clients to create an account is not active at this point. 

## Access
Access to the API is through the url 

```
/Lux/OAuth2/<api_name>
```

## External Access 
The OAuth2 system uses the standard OAuth2 model- and can be accessed by going to the URLs in accordance with OAuth2 standards:

```
/Lux/OAuth2/authorize/
/Lux/OAuth2/access_token/
```

## Dashboard
The Dashboard has a management where client information can be viewed. Clients can be created or modified- however client\_id and client\_secret are determined server-side and unmodifiable. Clients can not be deleted from this interface. 


/*&#x3b1*/
{
	 "access_token/":{
		 "return":{
			"access_token":"The Access Token that a third party can use to access user information via the API."
		}		
		,"params": {
			 "client_id" : "The client id that has been assigned to this client"
			,"redirect_uri":"The redirect uri that the user specified in the previous request"
			,"client_secret":"The client secret that has been assigned to this client"
			,"code":"The unique code that was granted by the authorize/ script"
			,"grant_type":"always equal to authorization_code"
		}
		,"description":"This can be called by a server to exchange the code for an access token"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":[]
	}



	 ,"authorize/":{
		 "return":{
			"code":"The code that the client can exchange for an access_token"
			,"state":"Identical to the state passed into the script"
		}		
		,"params": {
			 "client_id" : "The client id that has been assigned to this client"
			,"redirect_uri":"The redirect uri that the client specifies for lux to redirect to"
			,"response_type":"always equal to code for this OAuth system"
			,"state":"A variable that will be returned exactly as before to the client"
		}
		,"description":"The client must REDIRECT to this url in order for a user to login. Once the user has logged in, they are redirected to the client's redirect_uri for processing"
		,"rule":"N/A"
		,"database":{
			 "db":"Auth"
			,"collection":"Clients"
		}
		,"linked":[]
	}



	 ,"adjust/":{
		 "return":{
			"doc":"The new or updated client document"
		}		
		,"params": {
			 "client_name" : "The name of the client who is being created"
			,"redirect_uri":"The redirect_uri which the client will redirect their user to"
			,"description":"A description of the client"
		}
		,"description":"This call is used to either create or update a client id. Once a new client is created, a client secret and client id will be manually added to the document which is returned"
		,"rule":"N/A"
		,"database":{
			 "db":"Auth"
			,"collection":"Clients"
		}
		,"linked":[]
	}
	 ,"query/":{
		 "return":{
			"doc":"The client document or client documents"
		}		
		,"params": {
			 "[client_name]" : "The name of the client who is being queried. If left blank, all clients will be returned"
		}
		,"description":"Used to query for clients which already exist in the database"
		,"rule":"5, oauth"
		,"database":{
			 "db":"Auth"
			,"collection":"Clients"
		}
		,"linked":[]
	}
}
