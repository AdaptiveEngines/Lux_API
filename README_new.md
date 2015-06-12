# lux Software Development Toolkit
## Intro

Lux is focused on creating a more friendly market for start-ups and front-end developers to work in which allows them to be more self-reliant and more focused on developing their technology at their speed. Lux is not just a back-end as a service, but a full suite of products that are integrated into a single package that allows for creation of products, services, and business tools with a strong online presence. Lux is built to be built to grow, every aspect of lux can be easily tied together, while still being treated as a separate entity. This ability to grow and change with it's needs allows lux to be a powerful tool, and  big reason to make open-source a staple in that tool.

The specialized skills that may be worth hiring for (All short-stay hires) in the near future are listed below, although some skills may have been overlooked:

* Advanced Multi-Threading and distributed computing
* Advanced HTML/CSS/JS for front-end development
* PayPal/Stripe/ Any Online Payment Gateway system experience
* Advanced Shell/CLI Programming ability
* UDP/WebSocket optimization
* Real-time Streaming protocols (RTSP) building experience (not just interfacing with an existing)
* Other languages (for implementation of SDK libraries)

### Open-Source
The lux project is an open-source project designed to grow and expand with the needs of the community. Contribution should be limited and monitored through GitHub, and will need a dedicated team to approve pull-requests from non-employee contributors. Affiliated contributors are in-house developers volunteering their time towards the lux project and maintaining the lux repository. The open source area of lux consists of the Back-end library on which applications are built, in this document they fall under the category of "API Calls For Lux".

The Open Source analytics platform is built into the API Calls For Lux, and is attached to it's own server-side processes. The Redux sections will be primarily open source, and given a marketplace around them- giving the ability to sell and profit off of redux functions. The data analytics framework is closed source, and not publicly available for modification. 

The Open Source Community behind Lux will help to ensure that all possible features are developed and included in the lux library. Although any technology could theoretically be built on lux open source alone, the community is encouraged to use the closed source software as well. 

### A note on Overarching goals
Many Backend as a Service providers are focused on singular platforms or application types- hence Game Backend as a Service, and Mobile Backend as a Service. lux is designed to be applied to any sector or industry that it needs to be. Another theme in Backend as a service providers has always been to solve problems by increasing the amount of server-side hardware being utilized. Although this solution is unavoidable- lux should be able to scale well on a small server, and should not need an increase in hardware as it's only solution.

lux, unlike other backend services, should also have a heavy connection to it's analytics that creates an environment which not only services users, but also provides useful feedback about them and their interactions with the system.  
 
### Definitions, Acronyms, Abbreviations, and Terms 
* Developer: A developer working on top of a Lux instance to create an application
* Lux Developer: A developer working to develop Lux
* End-user: An application user who is using a third party application built on Lux by a developer
* lux Based products: Applications and Games Built on Lux.

### Scheme
Basic operations include:

* Upsert
	* Create
	* Edit
	* Remove
* Query

However for most APIs these should be broken down into finer detail, allowing only a few parameters to be altered with any given call. For almost all calls, the user should specify specific key->value changes to be made, and the php should handle those changes. In general, "Add" or "Create" and "Delete" should not be used, instead a function for "Adjust" should be used for editing an existing, and will create if one does not exist, "Adjust" can also remove whatever property with either a "remove" tag, or leaving the update field blank. Unless Specified as `~access_token`, all queries require an access\_token. If access\_token is optional (normally this changes behavior) then `~access_token?` will be used. Any GET request can also be a POST request, however POST requests can not be GET requests in all cases. 

Instead of Query, we should use get and fetch- where fetch is used when return value is dependent on user, and get is deterministic. Check should return a Boolean regarding the query (normally checking to see if a query is true or false)

The major exception to this, is Assets- which should be alterable via a direct Upsert so that they can remain as flexible as possible. For API wrappers (Social), the API should reflect the Social API as well as the users. The goal is to allow front-end developers to only use the lux API to create an entire application, and not need to interface with the server, or any other server, in any other way. 

### This document
This document is for the exclusive use of the lux team. Any alterations should be noted in the comments, and then after discussion the changes can be made. APIs in the first section are ordered by priority, however some leeway is permitted for ease of development purposes.  Please wait until you have discussed a section with the project lead before proceeding to build any aspect. 

Priority is listed in the title of every API, and currently range from 0-8. Priorities 0-3 are considered to be part of the open source project, and 4-8 are considered to be part of the proprietary lux software. Each API is also marked with a difficulty level:

1. Requires Only HTTP & Mongo Writes
2. Requires a class which can be added to other APIs
3. Requires Interaction with a non-Mongo database/third party service 
4. Requires Interaction with non-HTTP protocols to communicate with the End-User
5. Requires server-side scripts to be running which will need to be multi-threaded and optimized 

Priorities are superscripts $^x$, and difficulties are subscripts $_x$. Difficulty levels can be considered as the maximum number of days required to complete the section. 

----------

[TOC]


----------
# Global (Core) Classes 
## Database (DB)
The purpose of this class is to encapsulate database level operations which may be problematic to if a new database if database system is used, or that are just repeated often enough that they should be common. Ideally a class like this is implemented in c++ or compiled to a binary, however depending on the scripting language being used, that may not be possible. 

```c
+boolean checkPermissions(dId, uId, level)
+boolean checkPermissions(dId, level)
+database() // constructor
+database(db) // constructor
+database(db, collection) // constructor
+this selectCollection(collection)
+this selectDb(db)
+this selectDb(db, collection)
+document findAsset(id)
+document resolveDocument(document)
-document updateMeta(id)
-document stripPrivateData(document)
```

### Check Permissions
* document id
* user id 
* Permission level desired 
:
* boolean 

```c
// Use the existing database connection
// find the ownership document for the user
	// query that users document permissions
// Check if permission level == permission level desired
	// return previous
// if no user id then return true only if document is global
```

### Constructor
* Database Name
* Collection
:
* Object of this class

```c
// connect to the database and collection
// save the collection object as an object
```

###  Switch Collection
* New collection name
:
* void

```c
// connect to a new collection within the existing database
```
###  Switch Database
* New Database Name
* New Collection Name 
:
* void

```c
// connect to a new database
// select the new collection name if one is provided
```

### Find asset
* id || query
:
* document || cursor

```c
// run either find or findOne to get the appropriate document
	// return the document found
```

### Resolve document
* 1 Document
* user id
:
* 1 Document

```c
// iterate through the document and 
// find any _ids or dbRefs and resolve them
// check user permissions to view document and leave document id 
	// if the user does not have permissions 
// if user id is null, then assume only global documents are ok
```

### Update Metadata
* id
:
* new Document
Updates the metadata that is specified in the database section below. 

```c
// call before finding the document
	// update metadata and then return the new document
```

### Strip Private information
* document
:
* new Document
Strips out any private information that Users should not be able to see. (access tokens, passwords, ect). 

```c
// take in a document
	// remove private data section
```

### Update Key-Value
Updates a key value pair of a document 

```c
// upsert document Key-Value
```

# APIs

```c
- // indicates that access is limited by needing a User id
+ // indicates public behavior, no access token needed
# // indicates that an access token changes the behavior, but is not necessary
(-) // indicates that a user must have Administrative privileges 
```

## Asset Management System
The Asset Management API allows users to create Assets and store them in a specific Asset Database. This allows access to the Database via the standard commands, which gives users full access to the collections. The Asset Database can be broken down by collections which are defined by the developer. This Database (and set of collections) are the only ones with arbitrary structure defined by the Developer.

A Query with no access\_token will only return documents who have global access specified. All queries however should check access before returning a document. APIs should strip out lux\_info

This will be linked to

* Asset Management System
* Any XDE (flip)

```c
-Upsert(query || id, update, remove, coll)
-Adjust KV(Query || id, Key, Value, coll)
#Query(Query || id, Resolve, coll)
```
>document set-up is arbitrary and focused on developer needs 

### Upsert 
* Query || id
* update
* remove
* collection

Upsert is focused on the creation and alteration of assets. 

```c
// read the database collection and connect (new db)
// db.checkPermission(..,..edit)
// perform update or remove if user has edit permissions
```

### Adjust 
* Query || id
* Key
* Value
* Collection

```c
// read the database collection and connect [ new db()]
// db.checkPermission(..,..edit)
// perform update on one value if user has edit permissions
```

### Query
* Query || id
* Resolve
* Collection Name

```c
// read the database collection and connect
// db.checkPermission(..,..view)
// return entire document if the user has permission to view 
	// if resolve, db.resolve(document, user_id || null)
```

## User Management API
This API allows storage and creation of user documents, updating user values, and fetching the User's document. User documents should not be accessible via Upsert- but only Upsert- Key:Value and Fetch Me. Only a user should be able to access their own document, other user's should not have direct access to this document. If a User's profile information is to be made public to end-users, they should have a separate document for that in the User Profile API. This should contain log-in information, access_token, general system related info like settings. This is where their social access tokens are stored, however those are not exposed to the front-end. They should however be constantly refreshed so that they do not expire (unless they are given a lux expiration date).

The difference between this and the User Profile API is that this information is protected/private information, so it should not be accessible outside of the server. Some information can be duplicated between this and the User's Profile API.

```c
-Adjust KV(key, value)
-Fetch Me()
(-)Adjust User Access Level(id, level)
(-)Adjust Account Suspension(id)
```

### Adjust KV
* Key (optionally array)
* Value (optionally an array)

```c
// adjust a user's document information by key value
// check to make sure this is the user's document, and adjust it
// check an array of available values that can be adjusted or added
```

### Fetch Me

```c
// get the user's document from the database and return it to the user
// (if this is the user)
```

### Adjust User access Level
* id 
* Level

This adjusts the access that a profile has to the system- for instance, making an account an administrative account. 

### Adjust Account Suspension
* id
* Suspension Level

This adjusts if an account is suspended or not, it is associated with a black list for accounts, or a white list, which can prevent certain users from gaining access to any portion of the system. 

## User Profile 
The User Profile API is part of the Social network and stores public information about the user that can be accessed by any user who is authorized in the system. Information availability can be limited further by setting permissions on certain parts of a profile. This information is stored in the social network which will be built into Mongo

```c
-Adjust KV(key, value)
-Fetch Me()
-Adjust Profile Access Level(access_level)
#Get User(id)
```

### Get User 
* user id

Returns the public profile (or the profile if access is granted at that level) for a user

### Adjust Profile Access Level
* Access Level

Adjusts the access level of a profile to determine who can view the information on a profile. 

## User Asset Ownership
The User Ownership API is designed to track what Asset's a user is permitted to update. This API is designed to be hooked into the User Profile Document, and should automatically be checked from the Assets API to see if the user has proper permissions to change that Asset.

Some Assets will be globally alterable, and should thus be stored under a Global User. Some assets will be alterable by multiple users, and will therefore need multiple users to reference the Asset's Id.

```
-Adjust permission level(aid, uid, level)
-Fetch permission level(aid, uid)
#Fetch Owned Assets(uid)
#Get Asset Owner(aid)
#Get User's Assets(uid)
-Set viewing Rights(aid, uid)
```

## Social Network

The social network Allows users to be connected within this application/Lux instance specifically- and allows for user's to add friends, join, groups, ect. The functionality of a social network is limitless. This combined with the POI API could be very useful in finding nearby friends. The social network is implemented as a linked list graph in Mongo, where the profile document holds a list of connections. Each connection is split up by having a given type, and can hold relevant information (like basic data associated with the connection). 

```c
-upsertEdge(start, end, type, data)
-upsertEdge(eId, data)
-removeEdge(eId)
```

## Scoreboard
Scoreboard allows developers to easily keep track of user's score and Game state on a user By User bases. This is what is used by Leaderboard to assess user scores. The scoreboard features a series of arrays which can be created by the developer. Within each array there is a set of levels, which hold the score for that level, as well as other relevant information. Outside of the arrays, the developer can store individual metric information- which can be of any type. It is important to note that metrics, and even level scores, should be adjustable by using a (+) or (-) operator- and not an absolute value. 

Fetching user scoreboard returns the entire document, but if the scoreboard is not yours then certain information may be stripped- and more information may be stripped based on the connection that you have and the privacy settings that the user has set. 

Adjust the stat calc determines how the statistics are calculated, however developers must choose from a standard list. Statistics are the calculation of a ranking or summary associated with the scoreboard, but not the entire scoreboard. 

```c
-adjustLevelArray(levelArrayName, info)
-adjustLevel(levelName, score, info)
-adjustMetric(metricName, value, info)
-adjustItem(itemName, remove)
-fetchUserScoreboard()
#fetchUserScoreboard(userId)
-fetchUserStatistics()
#fetchUserStatistics(userId)
-fetchUserItems()
#fetchUserItems(userId)
-adjustPrivacy(options)
(-)setStatCalc(options)
```

## Leaderboard
Leaderboard allows you to query for leaderboard results based on a variety of criteria. This API has no alteration functionality- only a series of queries. All of the Fetches should have parameters to define how the leaderboard is calculated. Leaderboard simply returns a list of user documents and their statistics, ordered according to the values set forth in the options. The leaderboard should be using a form of mapreduce or aggregation within the mongo structure, in order to offload as much of the work as possible into mongo. Most of the statistics calculations should be shared functions with the scoreboard above.  

```c
-fetchFriendLeaderBoard(start, number, asc, options)
+fetchLeaderboard(start, number, asc, options)
-fetchFacebookLeaderboard(start, number, asc, options)
-fetchLocalizedLeaderboard(start, number, options)
```

## GeoLocation
This function is specifically for logging the location of a user in a system so it can be used for the POI API and the GeoFencing API. GeoLocation data should be stored in the user's profile information, and the profile should be given a Geo-index (at set-up) so that quick querying can be used. Geo-location can be used in both real world coordinates or in-game coordinates at the same time. For more information regarding this, refer to the [Mongo geospatial documentation](http://docs.mongodb.org/manual/applications/geospatial-indexes/). 

Queries here are directly related to the mongo queries, however they filter based on the user's privacy settings. The optional "Filter" can be used to eliminate results based on other criteria- for instance if they are your friend of not. These can only be used based on standard filters. 

```c
-adjustUserLocation(a, b, c, info)
-fetchUserLocation()
#getOtherUserLocation(userId)
-adjustLocationSharingSettings(options)
-getRadius(r,[filter]) // gets the radius around the user
#getRadius(a,b, r,[filter])
#getNear(a,b, n,[filter])
-getNear(,[filter])

```

## GeoFencing
This API allows for certain functions to be executed when a User is within a given area. Allows you to add a published document to the set when a Geo Fence is triggered. This will need a script running specifically for geofencing "cron" jobs. Although the parameters for the geoFence callback functions are defined by the system, the size (or shape) of the fence can be defined on the user level. For more information, reference the [Mongo geospatial documentation](http://docs.mongodb.org/manual/applications/geospatial-indexes/). 

```c
-adjustGeoFence(fenceId, callback, [expiration], options)
#adjustMember(fenceId, userId, remove)
-adjustMember(fenceId, remove)
-checkTriggers()
-fetchFences([active])
#getFences([active])
```

## Session Management

The Sesssion management system allows specific devices to save session variables (mobile, web, ect) on the server-side, so that when moving between pages/sections, or if there is a disconnect- then variables can be saved. Developers can also save access\_tokens in the session so that users who leave the page for extended periods do not need to loose temporary data. Session is the only thing that is validated by the requesting device and not the user's access token. Devices that can hold cookies can also use a cookie as the identifier for a session. All session information is written into Mongo on each call- in order to save sessions for extended periods (without adjusting php attributes).

$LF should also be able to access session info automatically in any other API.

Sessions are held in both the Mongo DB and the PHP (or other language) Session.

```c
+adjustAttribute(key, [value], [timeout])
+fetchSession()
+fetchSession(key)
+renewSession() // clears a sessions
+annihilateSession()// deletes the session and all it's attribtues
(-)mimicUser(userId)
```

## Groups Profile

## Groups Asset Ownership 

## Groups Social Network

## Groups Scoreboard

## Groups Account

## User Voting and Rating System
This API is designed to allow Users to be rated, voted, and commented on. This system is stored in a single document for each user, and can be used to rate users in a sale website, or a social game of some sort. The system allows for: 

* Votes - one per user
* Comments
* Ratings - one per user

```c
-vote(id, up/down)
-voteComment(commentId, up/down)
-rateComment(commentId, rating)
-adjustComment([commentId], comment, options)
-adjustSubComment([commentId], [subCommentId], comment, options)
-adjustRating(id, rating, options)
#getAVR(id)
```

## Asset Voting and Rating System
This API is the same as the above, but focused on Assets rather than Users. 

## User Tagging System
The Tag system allows tags to be added to a user and should be stored directly in the user's AVR. The Tag API allows developers to query based on tag, add tags, and get the most popular tags without writing custom queries for each operation. Tags are short (1 word or a short sentence) describing a user. Tags provide a text based mongo index for easy look-up and querying. 

```c
-adjustTag(id, tag, remove)
#fetchTags(id)
#getByTag(id)
#getSimilarTags(tag)
```

## Asset Tagging System
This API is the same as the above but focused on Assets rather than Users. 

## Achievements/Badges
Achievements/Badges are criteria that are automatically met based on Elements on the scoreboard. Users can attach actions to Achievements and track the number of actions that have been taken. Achievements can then be queried to find updates or new Achievements. Badges work in the same way as achievements, but there may be some subtle differences. Essentially all badges are treated like achievements by lux, but a developer may treat them differently. 

```c
(-)upsertAchievement(name, query, criteria)
-earnAchievement(aId)
#fetchAll()
-fetchMine()
-checkForAll()
```

## Social APIs
The Social API allows users to post to a variety of social media outlets from the Front-end, and allows Lux to track those social media postings. A developer should only need to send a single request to Lux in order to Post... whatever... and then the post should be processed By Lux- including access tokens, refresh tokens, ect.

The API should open up any functionality of the Social Media outlets API that is necessary- posting to their wall, getting their likes, ect... Developers should not need to connect to the Social Media API at all, but instead run all functions via Lux. The APIs are not specified here, but should be reflective of the APIs provided by the 3rd party. 


### Facebook
### Twitter
### Google/Google+
### Github
### IMAP Access 
### POP Access
### Ect

## Template Render Engine

This Service allows developers to query for a document and have it rendered into HTML, pdf, or another format before it is delivered to the End-User. This service will also connect to the CMS, to pull content items. The Template render should also include routing options to tell HTTP requests which file should be accessed.

The initial implementation only needs to handle Rendering HTML, and needs to be able to handle routing problems.

```
+fetch Page(path)
(-)Change Render Settings(key, value)
(-)Put Page
```

## CMS
This API allows developers to add content to a CMS which can be edited from within the Lux Intranet CMS Tool. The CMS API allows content to be uploaded and edited. Content can also be queried from the CMS API so that it can be rendered for the End-User.

```
(-) Adjust Field(fid, new)
+Get Field(fid)
(-)Adjust Render Options(fid, opt)
(-)Adjust Permission level(fid, level)
```

## API Proxy Service
This allows any Proxy that is set-up to the queried from the JS by forwarding the API call to the Proxy and returning the direct results of that API call to the JS.

The API Proxy service includes a way to make OAuth calls by looking for the User's access_token and making calls with that.


```
+MakeCall(api, params)
(-)UpdateAPIkeys(api, url, [key], [params])
```

## Auth
The OAuth should provide access to any OAuth provider that the developer chooses by adding only a single link. Users can have multiple accounts linked (Facebook, Google, Custom) to a single Lux Account. Each OAuth provider is only given a single call, which returns the link required to do an OAuth login. The Lux system handles the rest of the process serverside.

```c
+google(href, state)
+facebook(href, state)
+twitter(href, state)
+github(href, state)
+ect...
```


## Custom Auth
Custom Auth should allow users to create a profile and log-in using only the API.Things like account reset, and Reset Password are included in the Custom Auth functionality. This functionality should be simple at first, and the same login used for the lux system should be the default for the admin accounts. Later more complicated schemes can be used, like two step verification (via phone or email). 

```c
+signup(login, password) // password should be encrypted
+setAccountDetails(info)
+login(login, password) // password should be encrypted
+resetPassword(login)
(-)adjustLoginDetails(options)
+enterPinCode(login, pin)
```


## Roles & Rules
Roles and Rule sets can be arbitrarily applied to users and must be controlled on the front-end by adding calls to check the user's permissions on a given page. A User's roles and rules can dictate editing rights, page access rights, or ability to alter Rules & Roles. 

```c
(-)viewRules()
(-)adjustRuleset(id, ruleId)
(-)adjustRuleSettings(ruleId, options)
```

## System Roles & Rules
This system has the same API as above, but is applied to the entire system- opposed to just a single user. This means that custom functionality can be applied to customize the lux system using "module"-esq behavior. 

## Form Validation
This can be used to access specific form element types and validate their input serverside. This can be as simple as checking that an email is properly formatted to sending an email to check that their email is valid or verify a phone number is legitimate. Some of these values it is recommended to perform the check client side (min/max), however the server-side implementation is given anyway. The deep parameter validates authenticity- for instance sending an email to verify, or a text message, ect... If deep is specified, then a code is returned to be polled to check if the user's input was valid. The deepId is destroyed after it is checked. 

* required
* min length
* max length
* exists (in assets/user)
* range length
* min value
* max value
* email (tests that it is real)
* url (tests that it is real)
* date
* date ISO
* number
* digits
* credit card (checks that it is real)
* equalTo
* file Type
* phone number

```c
#validate(field, value, options, [deep])
#deepCheck(deepId)
```

## Timer Service
The timer Service creates an instance of a clock on a server which can be referenced as a "game time" or other use of standard timing (auction, ect) in order to determine when something expires according to server time. Timer callbacks are messages that can be published to the real-time script.

```c
-adjust(start, end, callback, options)
-adjustPeriodic(start, interval, end, callback, options)
-checkTimer(timerId)
```

## Facilitated Communication 
Facilitated communication is meant to add a social element to a website, allowing users to communicate either via Video, Audio or Text.

```c
-sendMessage(recipientId, message, [subject], attachments)
-sendTyping(recipientId)
-sendRead([received], [read], time)
-checkMessages(start, num)
-setStatus(message)
```

Variations of these can be used for multiple communication methods. 

## Survey Tool
This is a tool designed to allow the simple creation of surveys which can be viewed and edited via the intranet tool. Surveys are available as either anonymous or sign-in, and can be deployed internally or externally. Survey answers can be viewed in the intranet tool. Surveys can also be created by users who are then the only people able to access that information. Tests are a special form of Surveys which can be given correct answers. 

```c
-createSurvey(options)
-adjustQuestions(question, answers, [correct], options)
#getSurvey(sId)
#getAllSurveys()
#submitSurvey(questions/answers) // a key value array (if this is a test, return grades)
-fetchSurvey(grade)
-gradeTest(question/grade) // a key value array of questions that need manual grading
```

## Payment System
The Payment API is a method of integrating credit card payments into the site so they are naturally processed on the server- including setting up recurring payments, setting up future payments, processing credit cards, and automatically disabling features/access if payment is not processed. The Payment system can originally be a wrapper for the PayPal API, but later should be developed as a custom Direct Deposit payment system. The Payment system makes security crucial. 

## AJAX Search
The AJAX Search API acts as a querying functionality for Assets- but is tailored to search tags, multiple collections, and return a projected set of information to the database. Results are also be limited to a certain number- however a cursor object is created which allows them to view more results by querying just that cursor object.

```c
#search(query)
#next(searchId, start)
#searchIn(searchId, query)
```

## Collection Querying
Collection Querying allows for any arbitrary collection in any database to be queried, but not upserted.

```c
#query(database, collection, query)
```

## Newsletter 
The newsletter API allow you to add or remove members from a mailing list- add or remove newsletters to be sent out, and is linked to the User's document, so that suspending their account will remove them from the list, and updating the email on their account can update the email on the list. Non-account emails can also be added to the list. The newsletter API automatically appends an unsubscribe link, and allows you to send HTML based newsletters or mass emails out to Users and Subscribers. This will use the Amazon Message Sending Service (the one for mass no-reply emails). The Full API is not laid out here, but should be based on existing newsletter functionalities. 


## Image Processing
This API Allows you to run server side image processing on a file that has been uploaded to S3, and save that file back to S3 as well as return the original file to the Developer query.

* Create Editing Object
* Resize
* Thumbnail
* Scale
* Crop
* Convert Format
* Add Filter
* Add Layer
* Tile
* Rotate
* Slice image
* Add Object to Layer
* Transform/Move
* ect

```c
-alter(imageId, options)
```

## Recommendations Engine
This needs more planning- but originally will just recommend assets based on the current asset. Eventually it should track user activity, user searches, previous purchases, ect to come up with exactly which asset is desired. The Recommendations are heavily pulled from the analytics based on what a user has set or saved in their preferences. 

```c
#getRecomended([assetId], options)
```

## Virtual Server 
The virtual server API creates a temporary server box that users can access using API calls and file uploads, these boxes can be saved and destroyed via API, and output from terminal execution can be returned via API

```c
-createServer(options)
-destroyServer(options)
-runCommmand(serverId, command, options)
```

## Server Code Execution System
This API Allows users to simply execute a script that has been loaded via FTP onto the server, either by an HTTP Call or as a Cron Job. Server Code can be tested using the Virtual Server API. The Server code Execution system can be used to add custom functionality or add custom logic to a game which can (or should not) be executed on the client machine.

Although users are able to run server side scripts, this opens a myriad of security issues- so it is suggested to limit the user's server side scripts functionality, and interval to only be run at critical times when completely necessary. 

```c
(-)fetchServerScript([scriptId])
-runServerScript(scriptId)
(-)getRevisionHistory(scriptId)
(-)publish(scriptId)
(-)runTest(scriptId)
(-)runProtected(scriptId)
(-)adjustOptions(scriptId, options)
(-)uploadScript(file, options)
```




## Wishlist/Cart
The Wishlist API allows users to save specific items into several Wishlists. Wishlists can be moved into the shopping cart with an API call. Both the Wishlist and cart are unordered. A user can have as many wishlists or carts as the developer desires. 

```c
-adjustList(listName, type)
-adjustItem(assetId, listName, quantity)
-fetchList(listName)
-fetchAll()
-isEmpty(listName)
-checkout(listName) // archives list in third set
-clearList(listName)

```

## File Management

The file management API allows users to upload or access files that are stored on S3 or glacier- as well as access the elastic transcoder, and other server side file functionality. Assets can also be linked to Files, and Files can be given permissions and Access Rights from within the File Management API

```c
#uploadFile(file, name, info)
#getAll()
-getCount()
#getNamed(name)
#getAllType(type)
-removeFile(name, [id])
-link(fileId, userId/groupId, remove)
-archive(fileId, undo) // moves to and from glacier store
```

## MatchMaker 
The match maker is built on both the Social network, leaderboard, and achievements (as well as First come first serve matching), allowing you to query for a match- create a group- or create an instance of a game in order to play. The matchmaker API can also be used for matching individuals on a dating site to give recommended matches.

```c
#getCurrentGames(options)
#getGameServers(options)
#findGame(query)
#createGame(name, options)
#joinMatch(id)
#leaveMatch(id)
-fetchMatchCriteria()
-updateMatchCriteria()
#fetchMatchInfo(id)
#getMatches([start], [num])
```

## POI 
This API does not provide POI, but allows assets to be given "Locations" and allows querying to happen in reference to those locations. This means that you can query for assets and sort the results by distance, or some other criteria within a given distance. Developers are still expected to provide their own Assets/POI, the API just makes it easier to query for them.

```c
#getAll()
-adjustPOI(a,b,AssetId, info, [remove])
#getNearby(a,b,[r])
#getInside(poly)
```

## Logging 
The Logging API is primarily used for Analytics/Crash testing, and allows developers to log User Actions or Application Level Errors into a Lux Collection. The Timestamp, IP, and Other information will be automatically added as well.

```c
#Log(event_id)
#Log(event_id, trigger_id) 
#Log(section, event_id, trigger_id)
```

## Transaction API
The transaction server acts as the banking system within a Lux instance, and can be used to hold virtual currency or credits which are traded between players. This system is nessicary, but complicated due to security issues, so it will not be outlined in full here. 

Make Request
Encode Item Array
Transaction
Add User Account
Remove User Account
add Sub account
remove sub account
get Transaction History
get transaction detail
get account info
get subaccount info
add item to subaccount
remove item from sub account

## (Gr)avatar Service [low]
Create an avatar by plugging in certain variables and getting a full Model/image returned (which can be saved for quick generation). This is a silly add-on type feature and not a necessary element. The avatar should be highly customization and saved as a configuration document on the server-side, which specifies a set of either models or images, as well as options/parameters for those models/images. A fully formed configured avatar is returned as as single file when requested.  

## ShortCode Generator [low]
This API can be used to generate Short Codes and link them to a user or an Asset. It also allows developers to verify the Short code and return the Document that is linked to it. When a short code is

Generate Code
Attach to user
attach to reward
attach to location
attach to discount
redeem code
get code owner

## Reward Service [low]
Rewards, which are often mapped to short codes (or have short codes mapped to them) can work as a discount when using the payment system- and payment will be partially paid via a corporate account opposed to the user's account. Rewards can be given and tracked in a variety of ways. Rewards can also just be counted as a discount opposed to actually subtracting from the corporate account.

Create reward
Get reward description
Redeem reward
add reward to account
remove reward from account
use reward
Pass reward into payment

## Auction [low] 
This provides auction selling and buying functionality for unique Assets.

## Inventory System [low]
The inventory API allows developers to add and remove items from an inventory in order to track inventory.

## Order API [low]
The Order API allows users to place orders into an order system, and allows a second API to "fulfill" orders. Order Fulfillment is tied to the inventory system as well, and inventory and Shopping cart system as well.

## Forum Tool [low] 
This API acts as expected, allowing you to post to, or query a forum, as well as access elements of the forum like "reply" and creating threads. This may very well be integrated into the AVR set if necessary.

Create Forum category
update category
view category
view all categories
delete category
create forum
update forum
view forum
delete forum
create topic
update topic
view topic
delete topic
create post
update post
delete post

## Gift Management [low]
This API is focused on giving and receiving gifts within the social network- and just adds specific edges that are formatted as "gifts". It also contains a Mongo portion that allows for the creation and deletion of gift definitions, and can be used in parallel to either the payment API or the transaction server.

Create Gift
Distribute Gifts
Send Gift
Request Gift
Get Gift Requests
Accept Gift Request
Reject Gift Request
Remove Gifts
Get All gifts
Get Gift Count
Get Gift By Name
Get Gift By Tag
Delete Gift by Name

## Feedback and Helpdesk [low]
This API allows developers to add buttons and input boxes to the page which allow users to either evaluate the business, or request help. It can be linked to a chat system, or just an inbox system. The API should allow for messages to be both input to the system and Pulled out (on both the customer and business side). This will be linked to the Lux Intranet tool- which will provide an interface for businesses to view any feedback or help tickets that have been logged. Full API is not included here yet. 

Create ticket
email
name
requester_id
subject
description
status
priority
source
deleted
spam
responder_id
group_id
ticket_type
cc_email
is_escalated
attachments
due_by
cc_emails
Create ticket w/ attachment
View ticket
View Ticket List
Update Ticket
Pick a ticket
Delete a ticket
Restore a ticket
Assign a ticket
get All ticket fields
add note to a ticket
add note with attachment
view user tickets
view users on ticket
make agent
view agent
view all agents

## Ad Exchange/Network/Cross Promotion [low]
The Differences between these 3 boils down to where the ads are sourced from/how much is being paid for them, but the API would be wrapped into one- allowing you to pull ads based on the user, the page, ect. The API would determine (based on your criteria, and your account) which ad should be displayed. The ad Exchange/Network/Cross Promotion Portal would be located on the Lux Intranet Tools, and allows users to both post ads and use them. The Ad Portal should also be available outside of the Lux system, and linked to any Ad networks that we can link it to. The Ad Portal should be API based as well, but niether API will be laid out in full here

Create ad object
Create segment
Create ad unit (object, segment, geo, type [video, graphic, image], size)
Create GeoTag
Fetch ad Unit (by segment, geo, ect)
Fetch ad Object
Report Ad


## Massive Asset Voting And Rating System (User & Asset)
This API is designed to allow assets to be rated, voted, and commented on. The only difference is that this one is geared towards extremely comment heavy applications and will use MySQL instead of Mongo.

Same API as AVR so that they are quickly interchangeable within an application. A UI element will need to be provided to port all of the comments/ratings to the new system. 


# Databases/Collections
Some metadata is attached to all documents, including: 

* Created
	* Creator id
* Last modified
	* Revision (small stack)
	* Revision Author
* Last Accessed
	* Last Accessor
* Read only (only changeable by admins)
* Hidden (only accessible by devs)
* Archived (only accessible by admins or direct owner)
* Number of times accessed
* Avail Date (only changeable by admins) 
* Global Permission level

This is attached by the database class

## Assets
Points of interest can be stored in these collections as well. 

### Standard
This collection is the default for assets of general use, and can have any structure that developers wish to define. 

### < Developer Defined > 
This is multiple collections that can be created arbitrarily by the application to break assets up by collection in anyway necessary.

## Users
This information is specific to users, and is typically associated with 1 document in each collection/user account. 

### Account
This defines the user account and the private information associated with that account. 

Also stored here are the User's access token (current), their social access tokens (most recent) and a hashed version of their password- as well as the salt value being used for that user. It is important the no one have access to this information under any circumstances, and that it be stripped out by the database class. 

GeoFencing subscriptions are stored here, but that actual information associated with geofences are stored in the system database (System.GeoFencing). 

A User's Social Network Access Tokens are stored here, as well as authorization information for other Social APIs (email, ect). It is important that this information be stripped out by the database. 

### Profile
This defines the user's profile and holds information pertinent to their profile, including their social network, their connections and their public profile information. This information may have some repeats with their account information- but is not used for account information. 

A User's GeoLocation information should be stored here, but is closely protected by user permissions

Holds the configuration data for a user's avatar 

### Ownership
Lists the Assets that are owned or that a user has permissions on. 

### Social Network
Separate from the User profile, this document is just used for tracking the Edges between a given user and other users/groups

### Scoreboard
The Scoreboard exists to track a user's level and metrics for games or applications that need to track progression through metrics. The User's achievements and Badges are also stored in this section. Rewards are also held here. As are short codes for the user 

### Wishlist/Cart
The wishlist and cart document is used to hold several lists of assets that a user is interested in having. 

### Sessions
Unlike other collections in this database, this does not need to be associated with an exact user, and can instead be associated with a user's IP or cookie information. Like user documents, this document is accessible through KeyValue. There are not, however, restrictions on what a developer is allowed to store in these sessions. 

### User Voting and Rating System
The Same as the Asset voting and rating system, but associated only with the user. This same system would be used as a news feed. Tags for the Users are also stored here. 

### Transactions
Transactions are associated with User's and can be a combination of accounts, transactions, and other data. These are both transactions outside and inside the system- including tracking purchases in a game, or trades of virtual goods in a system. They may also track payments and purchases made by a user. Gifts are stored here as well.

### Payment System
The payment and credit card information of a user is stored here. This can only be accessed by the individual user, or a script running on the server. 

### Subscriptions
Holds what subscriptions each user is subscribing to. 

## Groups
The Group's database holds similar items to the User's database.  

## Asset Data
### Asset Voting and Rating System
The asset voting and rating system is associated with comments, voting, rating, and other such actions that can be taken on any asset in the Assets database. A DbRef is necessary. Tags for the Asset are also stored here. 

### Inventory 
The inventory is associated with the number of elements of a given asset type that are held in physical inventory. 

### Published
Holds documents from the Assets database that have been changed so that a subscription to those documents can be forwarded to the users. 

### Auction
For unique items (can not have multiple of the same item in the auction system) the system can hold an auction where user's can update their bid and wait for time to run out. 

### Recommendations Engine
Populated by the analytics, the recommendations engine holds the Apriori recommendations for an item. 

## System

### GeoFencing
This holds the geofencing information regarding where a geofence is, and the actions that should take place when it is triggered. 

### Achievements/Badges
This holds the Achievements and Badges that can be earned within a system and the queries that must be performed on a user's scoreboard in order to acquire that Achievement/Badge. 

### Templates
JSON Markup Templates (like html), which can be stored in full, and rendered into HTML by either a javascript engine or a server-side script.

### CMS
Holds the content that needs to be switched in. This should be done server-side by the template render engine, but can also be done on the client-side. 

### API Proxies
Holds the information necessary to contact 3rd party APIs (without user authentication, only system authentication) via a client side request. 

### File Management
Holds information relevant to files. Information that is not relevant to the actual file (like ownership and other data) should be held in an Asset collection. 

### Roles and Rules
This collection holds any system wide rules that have been defined. These are treated like modules and are associated with custom functions that need to be run. The collection simply holds the values of the rules and the rules that the system includes. 

### Timer Service
Keeps a list of Timers that have been created and a very accurate start time and function to be run when the time runs out. 

### Ad Exchange
Holds information regarding ads. Ads are referenced by URL to a separate instance specific for this need. Queries can also be saved here to target which user's should see which ads. Ad views and Ad clicks and data associated with ad's and ad revenue is stored here as well. Each ad is given it's own specific document. 

### Order System
This is for the fulfillment of physical goods that a user has ordered and holds the shipping address, payment verification, and shipping status of items that have been ordered in the system. User's can not access this, but can update it by purchasing an item. A user's order information is stored in the Transaction collection (Users.Transactions).

### Push Messages/Subscriptions
Holds the queries that a user can subscribe to so that the subscription can be pushed out on an update. 

### Newsletter
Holds the email subscriptions to a newsletter, as well as the newsletters being sent out to users. 

### Virtual Server 
Holds information regarding the creation of virtual servers and their owners/collaborators. 

### Server Side Execution
Holds information regarding scripts and server side code that should be executed.

## Facilitated Communication
The Facilitated Communication Database is designed to hold interactions between users and is closely coupled with the Social Network Graph that is created in the User's profiles. 

### Matchmaker
The matchmaker holds all existing and previous matches between users. Each "match" is given it's own document, and can be a match between users, groups, or numerous non-grouped users. Because of this, dbRefs are necessary. 

### Feedback and Helpdesk
This holds tickets, and comments about the system, as well as information on who was connected with a helpdesk official. 

### Forum Tool
Holds Forums and the comments left within a forum in a single collection. Each item in the Forum document is either a forum topic or the comments left on the forum. 

### Shortcode
Short codes can be generated to give user's an advantage or discount in the system and can be associated with other user's within the system

### Reward Service 
Rewards are associated with an upsert that can occur within the system, the actual rewards earned by a user are stored in the user's scoreboard. 

# Real-time Updates 
Real-time updates allow users to receive all Updates to the Asset Collection which match queries they are subscribed to over WebSockets or UDP. 

<!--## Assets
<!--## GeoFencing
<!--## Facilitated Communication
<!--## Push Messaging

<!--# Analytics APIs
<!--## Logs
<!--## Events
<!--## Custom Events
<!--## App Promotion
<!--## Crashes
<!--## Users
<!--## User Character Tree
<!--## Cohort Analytics
<!--## Buy Tracking
<!--## E-commerce
<!--## Location
<!--## App Store Analytics

<!--# Analytics Functions
<!--## Crash Processor
<!--## User Character Tree
<!--## Buy Tracking/e-commerce
<!--## Location Heat Mapping

<!--# Lux Tools and Services
<!--## Simulated Heavy Traffic Testing
<!--## API Generator
<!--## SDK Generator
<!--## API Documentation Framework
<!--## API Access Gateway
<!--## App Store Submission
<!--## Macro-based App Testing
<!--## AI/Neural Network Interface
<!--## Split Testing
<!--## Infographic Generator
<!--## Newsletter Tool
<!--## Internal Chat Tool
<!--## Programming test
<!--## Time Tracker
<!--## HR Toolset
<!--### Corporate Access System
<!--### Accounting Tools 
<!--### Receipt Tracking
<!--### Payroll
<!--### Contracts/invoice Manager
<!--### Auto Reports/Tax Form generator
<!--### Billing 
<!--## Order Management System
<!--## Inventory Management System
<!--## Helpdesk and Feedback Tools
<!--## Internal Game System
<!--## User Management Tools
<!--## Asset Management Tools
<!--## CMS
<!--## Lux Management Console
<!--### Manage Instances
<!--### Update Lux from Github
<!--### DNS Manager/Routing Manager
<!--### CPanel
<!--### API Service Management
<!--## Lux XDE (flip)
<!--### Hardware Design Suite
<!--### Hardware Component Creator
<!--### Hardware Simulator & Code Simulator (Arduino/Edison)
<!--## Pixlr Editor
<!--## Favicon Generator
<!--## Graphic Design Generator
<!--## 3D CAD/Animation
<!--## Gistbox
<!--## Component Marketplace
<!--## Ad Exchange/Network/Cross Promotion Marketplace
<!--## OS/Browser Emulator

<!--# Tools and Libraries
<!--## Sonic
<!--## Github integration
<!--## App Store/Submission
<!--## CMS Hooks
<!--## Cross Platform Tools
<!--## Hardware Integration tools
<!--## Localization Toolkit
<!--## Ad Integration Library
<!--## Mobile App Management Library
<!--## Mobile Device Management
<!--## App Monetization/in-App Sales Library
<!--## Automatic Offline Handling
<!--## App Store Optimization 
<!--## Automated App Testing
<!--## Beta Testing Distribution toolkit
<!--## IDE
<!--## Virtual Program Execution Environment 
<!--## ADE
<!--### Prototyping and Mock-up
<!--### Storyboarding
<!--### UI Framework
<!--### Native JS Framework
<!--### App Factory
<!--## GDE
<!--### Scripting and VPL
<!--### Asset Workflow
<!--### Scene Building
<!--### Game Engine Tools
<!--## Lux Business Development Toolkit
<!--### Company Creation toolkit
<!--### Manage Existing Company

# Lux Webserver
The purpose of this webserver is to act as both a standalone open source approach to a webserver which can manage Websockets in the same way that a standard HTTP request would be handled, and to act as a custom web server for the lux backend system. 

##Master/Controller
Acts as the Main script with the goal of starting and maintaining the webserver's operations. 

### Attributes
```cpp
vector<worker> workers;
// instantiated with static memory allocation to prevent
// singleton from being deleted 
Settings* settings = new Settings();
MasterInfo* info = new MasterInfo();
NetworkInfo netInfo;
NetworkSettings netSettings;
DistributionManager distManger;
``` 
* The workers vector is a listing of all the worker threads that have been spawn
### Methods
```cpp
int main( int argc, const char* argv[] );
int spawnWorker();
int spawnWorkers(int workers);
unsigned getHardwareCores(){ return std::thread::hardware_concurrency(); } 
int openTCPSocket(int port)
int openUDPSocket(int port)
```
#### main
* Creates the Settings object which is accessible in all classes as a singleton, however this should be where it is instantiated. Also creates the network Settings flyweight
* Creates the Mediator singleton which is used to Pass information between classes, same with the network mediator
* Creates a distribution manager which allows the program to communicate it's load settings to the rest of it's network and communicate a need for tunneling or DNS redistribution. 
* Checks to see how many CPU's there are on the machine and then launches 2 workers/core.
	* This number is saved to the Master Information mediator
* It adds these workers to the workers vector by calling spawnWorkers
	* Hardware affinity is not to be implemented

#### spawnWorker
* Spawns workers as new posix threads

#### spawnWorkers
* This is a composite for the spawnWorker() and simply calls spawnWorker the number of times specified

#### open TCP Socket
* Opens a TCP socket based on the port from the flyweight
* Saves socket to the mediator

#### open UDP Socket
* Opens a UDP socket based on the port from the flyweight
* Saves socket to the mediator


## *Worker*
Workers contains a vector of incoming request handlers which can be processed in a specific way. 

### Attributes
```cpp
vector<Request> requests;
vector<Tunneller> tunnels;
vector<NoRequest> noRequests;
ScriptExecutor SE;
```

### Methods
```cpp
work(); // constructor
~work(); // destructor
int handleRequest();
int createNoRequest();
int createTunnel();
int do();
```
#### constructor
* Creates the appropriate vectors and vforks off the "do()" process

#### destructor
* Tells all processes that they need to end, and then waits for them to finish before closing

#### handle Request
* Checks the open sockets for new incoming requests and spawns a new request handler if a message is waiting on the socket

#### createNoRequest
* spawns a new non-request handler of either Analytics or Server-side script as appropriate

#### createTunnel
* Creates a tunnel by consulting the master mediator for what server is not under heavy load

#### do
	* Checks to see if the vector limits have been reached (number of open connections), and allocates resources appropriately based on priority and load. priority and limits are acquired via the settings flyweight.

##  *Request*

### Attributes
```cpp

```
### Methods
```cpp
request(); // constructor
~request(); // destructor
static int checkSocket();
static int checkUpgrade();
static sendToStandard();
```
#### Constructor
* Calls the universal modules
	* calls the runModules of all the modules defined by the module chain 

#### check Socket
* checks both the UDP and the TCP socket from the master mediator
* If TCP then sendToStandard() in order to decrypt SPYD
* If there is a file waiting, then it creates a new request of the appropriate type by calling the constructor of the appropriate subclass and returning the request 
	* calls checkUpgrade to determine if the request is a Websocket
* Otherwise it does not create a request, and does not call the constructor

#### check upgrade
* Parses the HTTP request looking for an "Upgrade: websocket" line
	* If this line is present, it returns 1, else it returns 0

## Module Chain
simply defines the chain of responsibility for the modules being executed. This is defined in the constructor, but is pulled from the settings flyweight. 

Module chain can be passed a variable to determine which of the request types it needs to find and execute the chain of commands for. 

## *TCP Connection*

### Attributes
```cpp

```
### Methods
```cpp
tcpConnection() // constructor
~tcpConnection() // destructor
Object convertToObject();
virtual processHeaders();
int executeScript(string path);
int checkEOS();
```
#### constructor
* Grabs the connection and calls convertToObject

#### Destructor 
* Sends the EOS flag across the connection

#### Convert to Object
Converts the request into an object that can be more easily processed

#### Check EOS 
Checks to see if an EOS has been sent, if so, calls the destructor

#### Process headers
This is meant to be overridden for now and has no functionality on it's own. 
In the future, overrides may call the super of process headers if their is overlap between HTTP and Websocket

#### Execute Script
calls the execute script class in the worker to execute the appropriate script

## HTTP Handler

### Attributes
```cpp

```
### Methods
```cpp
processHeaders();
```

#### Process headers
Determines the request type and does other things that the headers need it to do. This is determined by the [complete list of HTTP headers](http://en.wikipedia.org/wiki/List_of_HTTP_header_fields)
* Normally most of this handling functionality will be done by the Request Type Handler

## Websocket Handler

### Attributes
```cpp

```
### Methods
```cpp
wsHandler(); // constructor
processHeaders();
```
#### Constructor
Responds to any incoming messages and then constructs a script executor to both observe for incoming messages that need to be processed, and execute appropriate scripts to send out new messages.

#### Process headers
Determines the request type and does other things that the headers need it to do. This is determined by the [complete list of HTTP headers](http://en.wikipedia.org/wiki/List_of_HTTP_header_fields)

## *UDP Connection*

### Attributes
```cpp

```
### Methods
```cpp
UDPConnection() // constructor
```

#### constructor
Converts the message into a separation of headers and message (if any headers exist), and puts the message into an object where appropriate

## UDP Handler

### Attributes
```cpp

```
### Methods
```cpp
UDPHandler(); // constructor
```
#### Constructor
Responds to any incoming messages and then constructs a script executor 

## Script Executor (Observer)

### Attributes
```cpp

```
### Methods
```cpp
checkNew();
sendCron();
```
#### Check new
Checks for new messages on the connection

#### send cron
Checks with the Flyweight for appropriate scripts and then executes them

## Live Template

### Attributes
```cpp

```
### Methods
```cpp
doThis();
```
#### do This
Defines the process necessary to determine and send messages to the open connection. 

## *Tunneller*

### Attributes
```cpp
vector<Tunnells>;
```
### Methods
```cpp
tunneller(); // constructor
```
#### Constructor
defines the behavior of the tunnel and provides a template for executing the tunnel

## Tunnel Creator

### Attributes
```cpp

```
### Methods
```cpp
tunnelCreator(); // constructor
```
#### constructor
creates a tunnel 

## Tunnel Forwarder

### Attributes
```cpp

```
### Methods
```cpp
forward();
```
#### forward
forwards any information coming through a tcp connection across the network blindly to another server. 

## *OS Socket Adapter*
Defines an interface to be used on all systems that can open a TCP or a UDP connection and send messages across them

## *Non-Request*

### Attributes
```cpp

```
### Methods
```cpp
noRequest(); // constructor
```
#### constructor
* defines a template for running scripts 
* declares the script parser to be used for the scripts

## Analytics Framework
Runs the scripts associated with the analytics framework 

## Server-side Script
Runs the scripts that need to be executed on the server without being requested by a user

## Execution Observer
Reads the settings flyweight and determines which scripts need to be run when, and then keeps track of when scripts need to be executed. Similar to "setInterval" for javascript. 

## Execution Schedule
Holds the actual schedule for the observer to abide by. 

<!-- ## *Script executor*
<!-- ## *File Parser*
<!-- ## File Parser
<!-- ## File Reader
<!-- ## Executor Module
<!-- ## Static Cache w/ revalidation
<!-- ## File Retriever
<!-- ## Environment Creator
<!-- ## Session Management Creator
<!-- ## Mime Type Handler
<!-- ## Folder Settings
<!-- ## Settings Flyweight
<!-- ## Memento Rollback
<!-- ## Master Info Mediator
<!-- ## Network Mediator
<!-- ## Network Flyweight Updater
<!-- ## Distribution Manager
<!-- ## Request Type handler
<!-- ## *HTTP Request Types*
<!-- ## CONNECT
<!-- ## GET
<!-- ## PUT 
<!-- ## DELETE
<!-- ## POST
<!-- ## TRACE
<!-- ## HEAD
<!-- ## OPTIONS
<!-- ## Header Processor
<!-- ## Response Header Builder
<!-- ## File Mapping
<!-- ## Log File
<!-- ## URL Parser
<!-- ## URL Rewrite
<!-- ## Gateway to File Server
<!-- ## Java Executor 
<!-- ## C++ executor
<!-- ## Ruby Executor
<!-- ## Python Executor
<!-- ## php Executor
<!-- ## Template Parser
<!-- ## *Module* (Non-Request)
<!-- ## *Module* (Request)


<!--# Lux Database

