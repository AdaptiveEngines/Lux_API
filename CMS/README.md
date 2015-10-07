# Content Management System 
The Content Management system can be used for a variety of purposes, including basic content sections or blog-esq posts. The main content can also have a shortened version attached. Header, sub heading, and url\_safe header's are also allowed- as are pictures and banner images. 

In addition, the template render system can be used to display content without needing to make a seperate call to fetch that content.

## Access
Access to the API is through the url 

```
/Lux/CMS/<api_name>
```

## Dashboard
The content management system within the Dashboard allows the editing and creation of content

/*&#x3b1*/
{
	 "adjust/":{
		 "return":{
			"doc":"The updated users document"
		}		
		,"params": {
			 "field_name" : "A unique identifier for this section"
			,"content.short" : "A shortened version of the content for display"
			,"content.full" : "A full version of the content for display"
			,"header.text" : "The header of the content"
			,"header.sub" : "The sub header"
			,"header.url_safe" : "A unique identifier that can be used to find the content via URL"
			,"picture.banner" : "A single identifying picture of the content"
			,"picture.slideshow[]" : "A slideshow that is relevant to the content"
			,"picture.other[]" :"Other pictures that may be relevant to the content"
		}
		,"description":"The adjust section is used solely in the content Management system and is used to create content that can be shown on the remainder of a site or application." 
		,"rule":"5, cms"
		,"database":{
			 "db":"System"
			,"collection":"Content"
		}
		,"linked":[]
	}
	,"query/":{
		 "return":{
			"doc":"The user or userss documents"
		}		
		,"params": {
			 "[field_name]" : "The field you would like to retrieve"
		}
		,"description":"Retrieve the content for use in either the dashboard CMS or for display"
		,"rule":"N/A"
		,"database":{
			 "db":"System"
			,"collection":"Content"
		}
		,"linked":[]
	}
}
