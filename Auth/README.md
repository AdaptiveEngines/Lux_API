# OAuth Gateway
The Auth Gateway is designed to simplify the OAuth 1 and OAuth 2 process by allowing developers to make a single request for the redirect url (sign-in button), which user's can click on to log-in. Once logged in, the user is assigned a lux access token, which allows them to interact with the system. Lux keeps the access token from the OAuth provider on hand for use when a developer wishes to integrate the system. Calls to APIs then automatically have the access token from the provider added to them. 

Social integration is done via the `/Lux/API/call/`, as a generic API system for all API calls

User's are able to log into multiple OAuth providers and have them linked to their account. 

## Access
Access to the API is through the url 

```
/Lux/Auth/<api_name>
```

## Dashboard
The Dashboard has a management where provider information can be viewed, created or modified for either OAuth1 or OAuth2 providers. 


/*&#x3b1*/
{
	 "OAuth/":{
		 "return":{
			"url":"The link that user's can be redirected to in order to complete the OAuth process"
		}		
		,"params": {
			 "provider" : "The name of the provider which developers would like to use for the login"
			,"[redirect_domain]" : "The optional domain of the redirect if it is not the same as the Lux serer"
			,"[href]" : "The optional path of the redirect if user's do not wish for it to be the webroot"
			,"[scope]" : "The scope parameter is optional if the default scope is set, however it is always recomended to specify the scope that your application requests"
		}
		,"description":"Developers need only make a single request to this link in order to retrieve the entireOAuth system"
		,"rule":"N/A"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}



	 ,"adjust1/":{
		 "return":{
			"doc":"The updated provider's document"
		}		
		,"params": {
			 "provider_name" : "The name of the provider"
			,"callback":"The OAuth protocol"
			,"consumer_key":"The OAuth protocol"
			,"signature_method":"The OAuth protocol"
			,"default_scope":"The OAuth protocol"
			,"base1":"The OAuth protocol"
			,"base2":"The OAuth protocol"
			,"base3":"The OAuth protocol"
			,"base4":"The OAuth protocol"
			,"base5":"The OAuth protocol"
		}
		,"description":"Add an OAuth 1 provider to the database. OAuth 1 is not currently implemented, so details are left blank."
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}



	 ,"adjust2/":{
		 "return":{
			"doc":"The new or updated provider document"
		}		
		,"params": {
			 "provider_name" : "The name of the provider who is being created"
			,"client_id":"client_id obtained from provider's developer dashboard"
			,"client_secret":"client_secret obtained from the provider's developer dashbaord"
			,"default_scope":"default scope from the providers available scopes"
			,"base1":"URL ending in authorize of auth"
			,"base2":"URL ending in access_token or token"
			,"base3":"URL to get user's profile information"
		}
		,"description":"This call is used to either create or update a provider for OAuth2."
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Clients"
		}
		,"linked":[]
	}





	 ,"query1/":{
		 "return":{
			"doc":"The provider document or provider documents"
		}		
		,"params": {
			 "[provider_name]" : "The name of the provider who is being queried. If left blank, all providers  will be returned"
		}
		,"description":"Used to query for OAuth 1.0 providers which already exist in the database"
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}




	 ,"query2/":{
		 "return":{
			"doc":"The provider document or provider documents"
		}		
		,"params": {
			 "[provider_name]" : "The name of the provider who is being queried. If left blank, all providers  will be returned"
		}
		,"description":"Used to query for OAuth 2.0 providers which already exist in the database"
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}

}
