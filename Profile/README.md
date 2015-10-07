# Profile Management System
Profile Management is the Social Network profile, and does not include account information or access\_tokens. The user's profile is managed and created by the user in order to give display information. The Social Network is also where information acquired from OAuth providers is stored. 

## Access
Access to the API is through the url 

```
/Lux/Profile/<api_name>
```

## Dashboard
The Dashboard has a management where Profile information can be viewed, created or modified within the system.


/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated Profile document"
		}		
		,"params": {
			 "query" : "The Query for the profile"
			,"update" : "The update array you would like to apply to the assets, or a single field to unset"
			,"[profile_name]" : ""
			,"[profile_picture]" : ""
			,"[images[]]" : ""
			,"[bio]" : ""
			,"[id]" : "The Id of a specific profile"
			,"[remove]" : "true If you would like to remove the profile"
		}
		,"description":"The developer can store basic information here. The information stored in this section may be used in other lux functions, however is restriced to certain values only. If the developer wishes to store more values, or a larger variety of values, they should use the `custom` api. "
		,"rule":"0, profile"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"custom/":{
		 "return":{
			"doc":"The updated Profile document"
		}		
		,"params": {
			 "query" : "The Query for the Asset"
			,"[id]" : "The Id of a specific asset"
			,"[remove]" : "true If you would like to remove the profile"
		}
		,"description":"Here the developer can store a more generaliezd list of information"
		,"rule":"0, profile"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The document or documents matching the specified criteria"
		}		
		,"params": {
			 "query" : "The query you would like to use to find documents"
			,"[id]" : "The id of a specific document if known- this is useful if you like to an asset and would like to only query for that asset"
		}
		,"description":"The developer can query for information as nessicary"
		,"rule":"0, profile"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Users"
		}
		,"linked":[]
	}
}
