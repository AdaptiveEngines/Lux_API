# Contact Form
The contact form is designed to keep the email address of personel off of the client side, and stored in the database. Although the functionality is very simple, and there are only 3 available API calls at this time, the functionlity is nonetheless very important to avoid spam mail. 

## Access
Access to the API is through the url 

```
/Lux/Contact/<api_name>
```
## Dashboard
In the Dashboard, the email's available for contact can be either added or removed in the System Set-up menu. 

A test of the contact form's functionality can be seen in the Test section of the dashboard

/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated email addresses available"
		}		
		,"params": {
			 "email_id" : "The unique identifier string for the contact form"
			,"address[]" : "The email addresses who should recieve this email"
			,"sender" : "The default sender if the mail is not coming from a client address"
		}
		,"description":""
		,"rule":"5, contact"
		,"database":{
			 "db":"System"
			,"collection":"Contact"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The contact form or forms"
		}		
		,"params": {
			 "[email_id]" : "The unique identifier string for the contact form"
		}
		,"description":""
		,"rule":"5, contact"
		,"database":{
			 "db":"System"
			,"collection":"Contact"
		}
		,"linked":[]
	}
	,"sendmail/":{
		 "return":{
		}		
		,"params": {
			 "email_id" : "The Unique identifier string for the contact form"
			,"subject" : "The subject of this mailing"
			,"body" : "The body of hte mailing"
			,"[sender]" : "The sender, if the sender should appear as the client"
		}
		,"description":"A single call to this from the developer allows the user to send an email to any stored address (managed from the Dashboard) without needing to expose the email on the front-end."
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Contact"
		}
		,"linked":[]
	}
}
