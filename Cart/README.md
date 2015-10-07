# Shopping Cart / Wishlist
Designed to reflect existing shopping cart and wishlist functionality, the shopping cart is simply an array of assets. Within this array, the assets are simply listed by id. User's may have multiple shopping carts or wishlists, which will default a set of given names (default). If a user wishes to place an order, their entire shopping cart will be moved to the order field- where they are able to place their order. This order will then be available to administrators in the Order API. 

For any given shopping cart functionality- it is up to the developer to decide if assets are purchased based on a 1 to many ratio of assets to physical goods- or a 1 to 1. The wishlist can be used for functionality that does not include orders- and will appear simply as a list of asset ids. Once the wishlist/cart has been returned, user's will need to requery for all of the assets. Since db refs will be used to store the assets- it is possible to resolve them before returning them to the user.

## Access
Access to the API is through the url 

```
/Lux/Cart/<api_name>
```

## Dashboard
The Dashboard contains an order management section. Although individual shopping/wishlists can not be seen here- you are able to see any orders that have been placed- sorted by user. Orders are entered as individual item's ordered seperately to accommadate different distribution channels

/*&#x3b1*/
{
	 "add/":{
		 "return":{
			"cart":"The Entire cart document associated with this user"
		}		
		,"params": {
			 "[collection]":"The collection that the cart asset can be found in"
			,"[cart]":"The name of the cart that the user wishes to add the item to"
		}
		,"description":"This call is meant to add items directly to your cart. If you wish to remove the items, you can specify the remove flag and the item will be pulled from your cart."
		,"rule":"1, cart"
		,"database":{
			 "db":"Inventory"
			,"collection":"Cart"
		}
		,"linked":[]
	}
	,"wish/":{
		 "return":{
			"cart":"The Entire cart document associated with this user"
		}		
		,"params": {
			 "[collection]":"The collection that the asset can be found in"
			,"[wishlist]":"The name of the wishlist that the user wishes to add the item to"
		}
		,"description":"This call is meant to add items to your wishlist."
		,"rule":"1, cart"
		,"database":{
			 "db":"Inventory"
			,"collection":"Cart"
		}
		,"linked":[]
	}
	,"move/":{
		 "return":{
			"cart":"The Entire cart document associated with this user"
		}		
		,"params": {
			 "[wishlist]":"The name of the wishlist that the user wishes to add the item to"
			,"[cart]":"The name of the cart that the user wishes to add the item to"
		}
		,"description":"This call will move an entire wishlist into your cart- but will not delete the wishlist, and will not remove any existing items"
		,"rule":"1, cart"
		,"database":{
			 "db":"Inventory"
			,"collection":"Cart"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"Cart":"The user's wishlist/Cart document"
		}		
		,"params": {
		}
		,"description":"This call will return your entire cart/wishlist document."
		,"rule":"1, cart"
		,"database":{
			 "db":"Inventory"
			,"collection":"Cart"
		}
		,"linked":[]
	}
	,"order/":{
		 "return":{
			"Order":"The user's order document"
		}		
		,"params": {
			"[cart]":"The name of the cart that the user wishes to order from"
		}
		,"description":"This call will return the user's order document. The user can specify a cart, however the cart will be cleared and moved into the order section. Orders are then accessible by admins with order rights- however user's are still able to manage their order using the order API"
		,"rule":"1, cart"
		,"database":{
			 "db":"Inventory"
			,"collection":"Orders"
		}
		,"linked":[]
	}
}
