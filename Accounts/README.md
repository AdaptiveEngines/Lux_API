# Accounts
Accounts is meant as a way to manage and view user account information- excluding user profile information. The user can be adjusted and queried, including their email, username, roles, and permissions. 

In order to modify your own account, user's must access their account using the CAuth functionlity, and not the Accounts API.

## Access
Access to the API is through the url 

```
/Lux/Accounts/<api_name>
```

## Dashboard
The Dashboard has a management where account information can be viewed, created or modified for Any account that has lower permissions than your own. 

```
/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated users document"
		}		
		,"params": {
			 "user" : "User's username"
			,"email" : "User's email"
			,"role" : "User's role must be less than 7"
			,"permissions[]" : "User's permissions in a comma seperated list (no spaces)"
		}
		,"description":"Adjust the User's information in the database. If the user is newly created, a username and password will be sent to the email provided"
		,"rule":"5, accounts"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The user or userss documents"
		}		
		,"params": {
			 "[user]" : "The user you would like to retrieve"
		}
		,"description":"Retrieve the user's documents for use in the dashboard"
		,"rule":"5, accounts"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":[]
	}
}
