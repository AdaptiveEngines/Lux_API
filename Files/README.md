# File Upload
The File upload API allows a simple way to upload files via Ajax to the server. Upload can also be used to view the files and file structure, create folders, remove folders, copy files, remove files, and move files. Admins have access to two folders- one for file uploads, located at `/uploads` from the webroot- and the other being the html root for this website, located at `/`. In the future, the webroot and the uploads folder will not be related in the same manner. Admins have access to the webroot- where as users only have access to the uploads folder. 

## Access
Access to the API is through the url 

```
/Lux/Uploads/<api_name>
```

## Dashboard
The Dashboard has a file managment system that shows the file structure within the two available directories and allows you to manage the files directly from the dashboard. 

/*&#x3b1*/
{
	 "upload/":{
		 "return":{
			"file":"information about the file, including a base64 url of the file"
		}		
		,"params": {
			 "path" : "Path within base directory"
			,"name" : "User readable name of the file (file will be renamed)"
			,"file" : "The fileHandler from the Javascript"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"The upload will allow the file to be uploaded to the proper directory, and rename the file to a unique filename"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"structure/":{
		 "return":{
			"dir":"Returns the directory structure and information about each file"
		}		
		,"params": {
			 "path" : "path within base that you would like to search"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"Lists all of the folders and files within the path specified"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"makedir/":{
		 "return":{
			"dir":"Returns the directory structure and information about the new directory"
		}		
		,"params": {
			 "path" : "path of the new folder, this can include multiple subdirectories along the new path"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"Create a new folder or folders within the base structure"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"cp/":{
		 "return":{
			"dir":"Returns the directory structure and information about the new directory"
		}		
		,"params": {
			 "path_new" : "path of the new file"
			,"name_new" : "Name of the new file"
			,"path_old" : "path of the old file"
			,"name_old" : "Name of the old file"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"Copy a folder to a new location"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"mv/":{
		 "return":{
			"dir":"Returns the directory structure and information about the new directory"
		}		
		,"params": {
			 "path_new" : "path of the new file"
			,"name_new" : "Name of the new file"
			,"path_old" : "path of the old file"
			,"name_old" : "Name of the old file"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"Copy a folder to a new location"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
	,"rm/":{
		 "return":{
		}		
		,"params": {
			 "path" : "path of the file"
			,"name" : "Name of the file"
			,"[admin]" : "Setting this to true changes the folder base"
			,"[admin_base]" : "Setting this to true allows the folder to be changed"
		}
		,"description":"Deletes a file from the server"
		,"rule":"1, files"
		,"database":{
			 "db":"N/A"
			,"collection":"N/A"
		}
		,"linked":[]
	}
}
