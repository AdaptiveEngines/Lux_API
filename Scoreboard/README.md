# Scoreboard System
The Scoreboard is designed to be a fully functional scoreboard and Asset Tracking system. This includes the ability to create and adjust metrics, Levels and Sublevels, and place items (Assets) into the user's possession. 


## Access
Access to the API is through the url 

```
/Lux/Scoreboard/<api_name>
```

## Dashboard
The Dashboard has a management where Asset information can be viewed, created or modified within the system.

## Logging 
When a User adjusts an asset or queries for an asset, the query that is used is stored as the trigger

```

/*&#x3b1*/
{
	"get/":{
		 "return":{
			"doc":"The user's scoreboard document or an array of scoreboard documents"
		}		
		,"params": {
			 "[id]" :"the id of a specific user's scoreboard to return" 
			,"all" :"true if you would like to view the scoreboard of all user's" 
		}
		,"description":"This method is used to view a single user's scoreboard, your own scoreboard, or all user's scoreboards"
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Asset/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "asset_id" :"The Id of the specific asset that you would like to add to the user's collection" 
			,"[quantity]":"The optional number of assets to add/subtract from this user's possession. Default is +1" 
		}
		,"description":"The asset_id can be added to the user's collection, and a quantity can be added. This call does not require that the user's possessions be known, just the quanitity (positive or negative) to adjust by. If the user falls into a negative quantity however- this script will not make an adjustment, and will instead return an error message."
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Level/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "level_id" :"The level id that is being created- this can be any unique string used to identify the level"
			,"[remove]" :"The optional arguement to remove the level from the levels array"
		}
		,"description":"Creates or removes a level entry in the levels array"
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Metric/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "metric": "The metric you would like to adjust"
			,"[value]": "The value of the metric, optional when change is included"
			,"[change]" : "The change to the metric value- only valid when the metric is a numerical value"
		}
		,"description":"Allows a metric to be associated with the scoreboard overall (overall score, ect)"
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Level/Metric/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "level_id" :"The unique string used to identify the level"
			,"metric": "The metric you would like to adjust"
			,"[value]": "The value of the metric, optional when change is included"
			,"[change]" : "The change to the metric value- only valid when the metric is a numerical value"
		}
		,"description":"Allows a metric to be associated with a level (level score, ect)"
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Level/Sublevel/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "level_id" :"The level id that is being created, this can be any unique string used to identify the level"
			,"sub_level_id" :"The level id that is being created, this can be any unique string used to identify the level"
			,"[remove]" :"The optional arguement to remove the level from the levels array"
		}
		,"description":"The same as for The level, but within a level. Levels may not have multiple layers of sublevels at this point, but that may change in the future."
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
	,"Level/Sublevel/Metric/adjust/":{
		 "return":{
			"doc":"The user's scoreboard document"
		}		
		,"params": {
			 "level_id" :"The unique string used to identify the level"
			,"sub_level_id" :"The unique string used to identify the sub level"
			,"metric": "The metric you would like to adjust"
			,"[value]": "The value of the metric, optional when change is included"
			,"[change]" : "The change to the metric value- only valid when the metric is a numerical value"
		}
		,"description":"The same as metrics for the Level, but associated with the sublevel instead. Levels can not have multiple depths of sublevels, just the one. This may change in the future."
		,"rule":"1, scoreboard"
		,"database":{
			 "db":"Scoreboard"
			,"collection":"Users"
		}
		,"linked":[]
	}
}
