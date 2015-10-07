# Logging API
The logging API is used for logging analytics from the application front-end. It is important to review what is being logged by the backend to avoid repeated logging- however repeats can be filtered out later by the analytics framework. The Logging API uses a strict set of Event Codes and Triggers which are defined below. Most developer defined Triggers are given a range.

## Access
Access to the API is through the url 

```
/Lux/Log/<api_name>
```

## Analytics Codes

### Inherent 

| Code | Trigger | Description | 
|------|---------|-------------|
|  1   | userid   | Any update for an user account that has been made will appear as this code |
|  2   | userid   | Any query for an user account that has been made will appear as this code |
|  11   | provider   | Any update for a provider that has been made will appear as this code |
|  12   | provider   | Any query for a provider that has been made will appear as this code |
|  13   | provider   | Any query to a provider API that has been made will appear as this code |
|  31   | asset query   | Any modifications to an asset|
|  32   | asset query   | Any queries for  an asset|
|  41   | asset id   | Any items added to a cart |
|  42   | 1 | Wishlist moved to cart |
|  42   | 2 | Items in Cart are orded |
|  42   | 3 | User viewed items in Cart/Wishlist |
|  43   | asset id | Item added to wishlist|


### Developer Defined

| Code | Trigger | Description | 
|------|---------|-------------|

## Dashboard
Information stored through the logging API will appear in the Analytics portion of the Dashboard.

```
/*&#x3b1*/
{
	 "Log/":{
		 "return":{
		}		
		,"params": {
			 "event" : "The event code being used"
			,"trigger" : "The trigger code being used (this should only be used once in the application code)"
			,"[role]" : "The severity, the default is 100, but can be adjusted for other events"
			,"[message]" : "Any notes you would like to add for debugging purposes"
		}
		,"description":"Adjust the User's information in the database. If the user is newly created, a username and password will be sent to the email provided"
		,"rule":"5, accounts"
		,"database":{
			 "db":"Analytics"
			,"collection":"Logging"
		}
		,"linked":["*"]
	}
}
