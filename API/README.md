# API Tunnel
The API tunnel is designed as a way to allow users to make calls to 3rd party APIs that require either OAuth or App level authentication, all while avoiding CORS. If the provider is properly set-up and user's are logged in, then access should be relatively simple.

It is important to note that the provider will throw an error if the path/params are not properly formatted- or if the request being made is out of the scope for the user.

## Access
Access to the API is through the url 

```
/Lux/API/<api_name>
```

## Dashboard
The Dashboard has a management where provider information can be viewed, created or modified for App level providers. 


## Logging
When a user makes an adjustment or fetches information from the API then the Providers name is stored as the trigger

```

/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated providers document"
		}		
		,"params": {
			 "provider_name" : "The name of the provider which developers would like to use."
			,"base_url" : "Base url for the request"
			,"key" : "The key assigned by the provider"
			,"key_name" : "The name for the key that the provider expects"
		}
		,"description":"Adjust can be used to alter the App level APIs that are saved in the system"
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The provider or providers documents"
		}		
		,"params": {
			 "[provider_name]" : "The provider you would like to retrieve"
		}
		,"description":"Retrieve the provider's documents for use in the dashboard"
		,"rule":"5, providers"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":[]
	}
	,"get/":{
		 "return":{
			"output":"The full output of the API as given by the provider"
		}		
		,"params": {
			 "provider_name" : "The name of the provider which developers would like to use for the login"
			,"path" : "The path of the request"
			,"params" : "The parameters of the request, excluding access tokens or keys, which will be provided by the system"
		}
		,"description":"Any request to this script will return the full and unaltered output from the provider. This output should be processed or displayed on the client-side as nessicary."
		,"rule":"N/A"
		,"database":{
			 "db":"Auth"
			,"collection":"Providers"
		}
		,"linked":["OAuth"]
	}
}
