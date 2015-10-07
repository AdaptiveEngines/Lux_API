# Psuedo Call system
The Psuedo call system is used to make calls to the Lux API and get a returned value (which is not an error) without needing to know actual values- and without needing to authorize. This is good for wireframes, walkthroughs and tests- but should be removed before any products go live. 

No real data can be pulled out using this API set. 

## Access
Access to the API is through the url 

```
/Lux/Psuedo/<api_name>
```


/*&#x3b1*/
{
	 "echo/":{
		 "return":{
			"doc":"All of the request variables that have been passed in"
		}		
		,"params": {
			"[any]" : "Any request variable that a user wishes to pass in can be passed in here."
		}
		,"description":"Will echo back all request parameters" 
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"simple/":{
		 "return":{
			"doc":"A few random variables named test1 test2... ect."
		}		
		,"params": {
			"[any]" : "Any request variable that a user wishes to pass in can be passed in here."
		}
		,"description":"Will print out the same array of output each time" 
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"list/":{
		 "return":{
			"doc":"An array of random objects"
		}		
		,"params": {
			"[any]" : "Any request variable that a user wishes to pass in can be passed in here."
		}
		,"description":"Will print out the same array of output each time" 
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"error/":{
		 "return":{
			"doc":"Throws an error"
		}		
		,"params": {
			"[any]" : "Any request variable that a user wishes to pass in can be passed in here."
		}
		,"description":"Will always throw an error, this allows you to see what an error may look like to your application." 
		,"rule":"N/A"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
}
