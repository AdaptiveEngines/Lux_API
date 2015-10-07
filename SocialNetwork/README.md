# Social Network
The social network acts as both a network between users, as well as a messaging system between users. Using this system you can access profiles, send messages, and add connections. At this point all profiles are public, however settings will be added later on to create more private systems. 

For most of the Query calls within this system, the first set of messages or posts is retrieved (25) based on most recent- and a second or third call can be made to retrieve the messages starting at 26-50, 51-75... ect. This eliminates some waiting time for the API as well as reduces the amount transmitted over the network. Each call that does this takes an optional start and limit, where defaults will be 0, and 25 respecitvely. 

## Access
Access to the API is through the url 

```
/Lux/SocialNetwork/<api_name>
```

## Dashboard
Although the dashboard does not have a section for Social Network, it does have a messages, profile, and notifications tab that all utilize the social network to view and interact with the social network. The social network within the dashboard is system-wide and does not apply only to the Dashboard itself. 

Notifications can also be generated on the dashboard which will show up in the notifications tab of the Dashboard. Users are able to view their inbox, send messages, and post to their 'feed'. Under the profile tab, you can view your own profile- and see your own feed.

A small tab maybe added to view other profiles/feeds- however editing of this information will not be available. You will need to search user's by username/email/ect.

/*&#x3b1*/
{
	 "add/":{
		 "return":{
			 "document" : "The connection document that has been created or modified"
		}		
		,"params": {
			 "id" : "The id you would like to add a connection to- either a group or user"
			,"[block]" : "Set if you would like to block the user"
			,"[unblock]" : "Set if you would like to unblock the user"
			,"[remove]" : "set if you would like to deactivate this connection"
			,"[description]" : "A description of the connection"
			,"[connection_type]" : "The type of connection- defined by system"
		}
		,"description":"Used to add a connection to either a group or individual. Either way, a database reference is used. Some information regarding the connection can be stored- for instance a description, the date, and how they are connected. This same information can be used for a group, or user connection. Connections can be 'removed' here, but they are simply marked as 'not connected' opposed to removed entirely- this allows for a connection to be restored without losing the data associated with that connection. 'removed' connections will not show up in the list of connections"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Connections"
		}
		,"linked":[]
	}
	,"find/":{
		 "return":{
			 "results" : "The list of items that matches the term in either user or groups"
		}		
		,"params": {
			 "term" : "The search term that you would like to use"
			,"[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"Finds a user or group based on a search term and returns their id, note that the limit and skip are applied seperately to groups and users"
		,"rule":"0, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Users || Group"
		}
		,"linked":[]
	}
	,"inbox/":{
		 "return":{
			 "documents" : "The threads in the user's inbox"
		}		
		,"params": {
			"[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"Here you can query for all of the message threads that you have been part of. This simply returns the message thread/subject, as well as who is involved in the message thread (dbRef). If you would like to see the content of teh messages, a seperate call must be made"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Messages"
		}
		,"linked":[]
	}
	,"list/":{
		 "return":{
			 "documents" : "The list of connections that a user has"
		}		
		,"params": {
			 "[id]" : "The id of the user whom you would like to see the connections"
			,"[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"List will show all of the connections that you have established, returning information about the connections. If a connection is pending, then that will be returned- however if a connection is not active, it will be left off of this list."
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Connections"
		}
		,"linked":[]
	}
	,"message/":{
		 "return":{
			 "thread_id" : "The id of the thread that this message has been added to"
		}		
		,"params": {
			 "[subject]" : "Optional subject for the message"
			,"[body]" : "Optional message body"
			,"[attachment]" : "The optional attachment or attachments of a message"
			,"[attachment[]]" : "The optional attachment or attachments of a message"
			,"[thread]" : "Thread_id is optional if to is set"
			,"[to]" : "to is optional if thread id is set"
		}
		,"description":"This allows you to send a single message and attach it to a thread. A thread can be between a group, or a person. If you send a message to a group- it will be recorded as a message from you, to the group. Groups are unable to send messages to other groups. If the thread id is unknown, then the 'to' field must be filled in. If an id belonging to a group or person is passed via the to field, the message may be added to an existing thread- or a new thread may be created"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Messages"
		}
		,"linked":[]
	}
	,"notification/":{
		 "return":{
			 "notificaitons" : "Most recent notifications, read or not"
		}		
		,"params": {
			 "[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"Notification returns all unread notifications that have been posted to the notification wall. This can be a variety of things. Any notification returned by this will be marked as read. That is an important fact"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Notifications"
		}
		,"linked":[]
	}
	,"numNotification/":{
		 "return":{
			 "num" : "Number of recent notifications"
		}		
		,"params": {
		}
		,"description":"The number of notificaitons that have not been seen"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Notifications"
		}
		,"linked":[]
	}
	,"notify/":{
		 "return":{
			 "notification" : "The new notification document"
		}		
		,"params": {
			 "[subject]" : "Optional subject for the notification"
			,"[body]" : "Optional notification body"
			,"[attachment]" : "The optional attachment or attachments of a notification"
			,"[attachment[]]" : "The optional attachment or attachments of a notification"
			,"to" : "to is optional if thread id is set"
		}
		,"description":"A notification is a message sent from the system to the user. In most cases notification will be generated when a different API call is made, which will tack a notification onto this list. This call is used when a notification is generated by another user- or the system would like to notify an admin in regards to something that has happened (front-end hook for if a user visits the blog?)"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Notifications"
		}
		,"linked":[]
	}
	,"post/":{
		 "return":{
			 "post" : "the new post document"
		}		
		,"params": {
			 "[subject]" : "Optional subject for the notification"
			,"[body]" : "Optional notification body"
			,"[attachment]" : "The optional attachment or attachments of a notification"
			,"[attachment[]]" : "The optional attachment or attachments of a notification"
			,"to" : "to is optional if thread id is set"
		}
		,"description":"This adds a post to either your own set of posts, or another user's. This can be used to implement twitter, facebook, google+, type functionality within your social network."
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Posts"
		}
		,"linked":[]
	}
	,"thread/":{
		 "return":{
			 "thread" : "All the messages on the thread"
		}		 
		,"params": {
			 "id" : "The id of the thread"
			,"[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"Retrieves the specific information from a thread of messages- including all of the most recent messages."
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Messages"
		}
		,"linked":[]
	}
	,"posts/":{
		 "return":{
			 "posts" : "The posts on the user's profile"
		}		
		,"params": {
			 "[id]" : "the optional id of the post owner you would like to query for"
			,"[skip]": "The number of messages to skip"
			,"[limit]": "The number of messages to include"
		}
		,"description":"Retrieves all of the posts that have been made on a specific user's profile. Post owner refers to who's profile the post is listed on"
		,"rule":"1, social"
		,"database":{
			 "db":"SocialNetwork"
			,"collection":"Posts"
		}
		,"linked":[]
	}
}
