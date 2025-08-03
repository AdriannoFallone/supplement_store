1. Upload Files:
Upload all files to your own web server root/subdirectory(including the db_export folder)

2. Create A Database:
Login to your provider's database management tool(ex. phpMyAdmin) and create a brand new database

3. Import Database:
Within the databae you just created, click on the import button and choose the .sql file in db_export folder.

4. Personal Config
Once imported, navigate to the file, db_connection.php to use your personal server credentials.  You will have to overwrite the defaults provided, and may have to do this in a few stand-alone files too that explicity call 
the default credentials.

5. Go To Website:
Finally, open a browser window and search the project URL, and you have now replicated the application.