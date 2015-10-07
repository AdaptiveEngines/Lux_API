# Ownership Management System
Ownership management is simmilair to a cloud file storage, but with Assets. There are several levels of ownership:

* Creator (Can't be altered)
* Owner (Can be reassigned, can also have multiple owners)
* Editor (Has editing/deleting rights but can not assign a new editor)
* Viewer (Has viewing rights but not editor)

each of which can be applied to either 

* A single user
* A group (applies to all members of the group)
* Global (A special group where everyone in the system is a member)

These rules are applied to assets automatically when a user tries to query for or adjust an asset. The Creator is assigned when an asset is created for the first time. Every other owner/editor/viewer has to be assigned through a seperate API call, placed by the owner. 

Much like a cloud file storage, any file that is uploaded to Lux is assigned an asset document. This asset document can then be given the same creator/owner/editor/viewer rights as any other- which can be used to disable editing or viewing of the document. 

## Access
Access to the API is through the url 

```
/Lux/Ownership/<api_name>
```

## Dashboard
The Dashboard has no ownership manamement, that has to be done through the API. The Asset management section will eventually give access to the ability to edit Ownership. 


/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":""
		}		
		,"params": {
			 "id" : "The id of the asset in question"
		}
		,"description":""
		,"rule":"0, ownership"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"mine/":{
		 "return":{
			"doc":""
		}		
		,"params": {
			 "id" : "The id of the asset in question"
		}
		,"description":""
		,"rule":"0, ownership"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":""
		}		
		,"params": {
			 "id" : "The id of the asset in question"
		}
		,"description":""
		,"rule":"0, ownership"
		,"database":{
			 "db":"System"
			,"collection":"Ownership"
		}
		,"linked":[]
	}
}
