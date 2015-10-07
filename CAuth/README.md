# Custom Authorization System
The custom Authorization system provides a simple API for logging a user in without using an OAuth provider. It is reccomended that the custom authorization system by used only if https:// certificates are properly set-up.

## Access
Access to the API is through the url 

```
/Lux/CAuth/<api_name>
```

## Dashboard
The Dashboard does not have a page for the custom Auth system, however the login page of the Dashboard is built on the custom auth. In addition, users can be managed on the Dashboard under

>Management >> Account Management

The calls utilized by the login page for lux are currently:

* authorize/
* verifyAccess/
* reset/
* create/
* exists/

meaning that they're functionality can be verified simply by creating a login for the system and logging in.  

* addEmail/
* change/
* eVerified/

will need to be implemented on the My Profile page of the Admin Dashboard in order to ensure that they can be tested from the Dashboard.

/*&#x3b1*/
{
	 "addEmail/":{
		 "return":{
			"access_token":"1234567"
			,"user":"User document"
		}		
		,"params": {
			 "access_token" : "The Lux Access Token that a signed in user should have"
			,"email":"The Email address that a user wishes to add to their account"
			,"[id]":"If being used by an admin, the id of the Account whom the email is being added to"
		}
		,"description":"The add Email system simply adds a new email to any existing user. This function does however overwrite the email that was previously in place."
		,"rule":"1 || 5, accounts"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]
	}




	,"authorize/":{
		"params": {
			 "password":"The User's Password"
			,"user":"The User's Username or email address"
			,"[response_type]":"If present then the system will return a code, the response type must by code."
			,"[client_id]" : "The client id if the call is being used for an OAuth 2.0 system"
		}
		,"return":{
			"access_token":"1234567"
			,"user":"User document"
		}		
		,"description":"The Authorize functionality can be used either on a custom login page, or on the OAuth login page. If used on the custom login page (as seen in the Dashboard Login), then the system will return a successful access token. This can then be used to redirect the user- or load new functionality. If used in conjuction with a response type == code, then the user will be returend a code, and not an access token. This code can then be used to acquire an access token from the 3rd party application's server."
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]
	
	}



	,"change/":{
		 "params": {
			 "access_token" : "The User's access token"
			,"password":"The user's old password"
			,"new_password":"The user's new password"
		}
		,"return":{
			"access_token":"1234567"
			,"user":"User document"
		}		
		,"description":"This call can be used by a user to change their own password. A new access token is returned after a user generates a new password. This can be used as a way to force user's to log back in, or can be accepted immediately as a new access token for the user."
		,"rule":"1"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}




	,"create/":{
		 "params": {
			 "user":"The user's desired username. Use exists to verify that this username is free and avoid an error being thrown."
			,"password":"The user's desired password"
			,"[access_token]" : "The user's existing access token from another login service."
			,"[email]":"The user's desired password reset email address."
		}
		,"return":{
			 "access_token":"123456"
			,"user": "example123"
		}
		,"description":"This call is used solely for the creation of new accounts within the lux system. A user can use this functionality to create a new login for the lux system. \n\n If an access token is provided, then it will be used to link the new account to the user's existing account. If an email is provided, then a verification will be sent to that email, requiring the user verify their email address. The user is still able to login even without verifying their email address, however the system could check if a user's email is verified and block functionality client-side if it is not. \n\n When a user creates a new account, regardless of if they are logged in already or not- a new access token will be created. This means that if a user creates a new account, they don't need to log in to access functionality unless the developer would prefer that they did."
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}





	,"eVerified/":{
		 "params": {
			 "access_token" : "The User's access token in the system"
		}
		,"return":"N/A"
		,"description":"Returns either sucess or error depending on if the user's email has been verified"
		,"rule":"1"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}




	,"eVerify/":{
		 "params": {
			 "email":"The email the link was sent to"
			,"eVC":"the email verification code included in the email"
		}
		,"return":"redirects to index page"
		,"description":"This call is only used by the lux system and allows the user to verify their email address in the lux system"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}




	,"exists/":{
		 "params": {
			"user":"The Username you wish to check"
		}
		,"return":"N/A"
		,"description":"Checks to see if a username exists in the system or not"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":[]
	
	}




	,"reset/":{
		 "params": {
			"user":"The username or email which you wish to reset"
		}
		,"return":"N/A"
		,"description":"A request to this will send an email to the user's verified email with a new password"
		,"rule":1
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}




	,"verifyAccess/":{
		 "params": {
			 "access_token" : "The user's access token"
			 ,"rule" : "The rule you wish to check the user against"
			 ,"[permissions]" : "The Permission you wish to check the user against"
		}
		,"return":"N/A"
		,"description":"This call will check if the user has above the given permissions. This is useful for checking if a user has access to a given page- based either on rule, or permission level, and can be used to check before creating a link, or when first accessing a page. This allows for users to be redirected before recieving an error for trying to perform an action they don't have permission's for"
		,"rule":"Variable"
		,"database":{
			 "db":"System"
			,"collection":"Accounts"
		}
		,"linked":["CAuth", "Auth", "Rules", "OAuth"]

	}
}
