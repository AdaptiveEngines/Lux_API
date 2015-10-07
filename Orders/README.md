# Orders
The orders API is designed as a way for both user's and admins to see products that have been ordered.

When looking at the order's, admins will be able to see all existing orders, sorted by the person who placed the order, and User's are able to see all of their orders. 

User's are able to update their order- including finalizing the transaction, where as admins are able to update the order's status- mark the order as seen, or mark the order as shipped. 

## Access
Access to the API is through the url 

```
/Lux/Orders/<api_name>
```

## Dashboard
The Order management dashboard is designed to allow administrators to view orders and manage the supply chain of that order directly from the management dashboard.

/*&#x3b1*/
{
	 "query/":{
		 "return":{
			"Orders":"Order documents from this user"
		}		
		,"params": {
			 "[skip]" :"The order number" 
			,"[limit]" :"The limit number" 
		}
		,"description":"Allows a user to get and view all their existing and previous orders."
		,"rule":"1, orders"
		,"database":{
			 "db":"Inventory"
			,"collection":"Orders"
		}
		,"linked":[]
	}
	,"pending/":{
		 "return":{
			"orders":"All the currently pending orders"
		}		
		,"params": {
			 "[skip]" :"The order number" 
			,"[limit]" :"The limit number" 
		}
		,"description":"Allows admins to view orders that have been placed, but not finalized"
		,"rule":"5, orders"
		,"database":{
			 "db":"Inventory"
			,"collection":"Orders"
		}
		,"linked":[]
	}
	,"ship/":{
		 "return":{
			"doc":"The order document for confirmation"
		}		
		,"params": {
			 "id" :"The order id that you are shipping" 
		}
		,"description":"Allows admins to ship an order and mark it as shipped in the system."
		,"rule":"5, orders"
		,"database":{
			 "db":"Inventory"
			,"collection":"Orders"
		}
		,"linked":[]
	}
	,"view/":{
		 "return":{
			"orders":"All the orders that have been placed"
		}		
		,"params": {
			 "[skip]" :"The order number" 
			,"[limit]" :"The limit number" 
		}
		,"description":"Allows admins to access all of the existing and previously shipped orders."
		,"rule":"5, orders"
		,"database":{
			 "db":"Inventory"
			,"collection":"Orders"
		}
		,"linked":[]
	}
}
