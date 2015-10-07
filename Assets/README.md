# Asset Management System
The Assets Management System is the universal API for managing the Assets in a database. The most basic useage is to create and store documents, which can be used in a variety of ways. 

Assets can be anything, from Assets in a game, items in a store, or Items in a barter system. Assets can either be treated as a unique item, or as a template for other items. When using the inventory or order system, Assets are mapped to the physical items on your shelves. Assets can be modified, or queried- just like most Lux systems, but without any rules regarding the schema of the Assets- that is determined by the developer.

## Access
Access to the API is through the url 

```
/Lux/Assets/<api_name>
```

## Dashboard
The Dashboard has a management where Asset information can be viewed, created or modified within the system.


/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated Asset document"
		}		
		,"params": {
			 "query" : "The Query for the Asset"
			,"update" : "The update array you would like to apply to the assets, or a single field to unset"
			,"[id]" : "The Id of a specific asset"
			,"[collection]" : "The name of the Collection"
			,"[remove]" : "true If you would like to remove the asset"
		}
		,"description":"Can be used to modify or remove a single Asset. This function does not allow for the modification of multiple assets. It is recommended that you always either use the id field to identify which asset you would like to modify, or query for a known unique identifier that you have set. This functionality does use upsert- so if an asset does not match the criteria of the query, one will be created."
		,"rule":"0, assets"
		,"database":{
			 "db":"Assets"
			,"collection":"*"
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
			,"[collection]" : "The name of the Collection"
		}
		,"description":"Queries for one or more assets form the database. This does not require any special permissions, however rules and permissions (as well as ownership) can be assigned to assets on a case-by-case basis."
		,"rule":"0, assets"
		,"database":{
			 "db":"Assets"
			,"collection":"*"
		}
		,"linked":[]
	}
}
