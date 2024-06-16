> [!NOTE]
> Please bear with me as this is the first major software I have ever built and published.

# GETTING STARTED

 ## Setting up your database and authentication parameters for the framework.

> In the Config folder within the root folder of the framework, you will find conn.inc.php, simply [define the constants](https://www.w3schools.com/php/php_constants.asp) of DBHOST, DBNAME, DBUSER, and DBPASS.
> Within the config folder is nodb.php to create your database. Get to this from the browser by going to this file through your server (ex. [https://localhost/Config/nodb.php](https://localhost/Config/nodb.php))  

 ## Setting program static variables.

> Next is setting the variable in ConfigVars.php.
> Change the working directory on approximately the 7th line to the file path you are working in after your domain (ex. https://localhost/phpcupcakeshop would be `private static $workingdirectory = '/phpcupcakeshop';`)
> Set the function `'myAppName()'` to change all the titles throughout the admin panel quickly.
> Last is the search model param needed for the search functions to work.  open [https://localhost/Config/findsearchparam.php](https://localhost/Config/nodb.php) and it will tell you the number to put in.

 ## Checking out the admin panel.

> Open the welcome screen to PhpCupcakeShop and click 'Enter Admin Panel in Demo Edit Mode'. There you will have access to the CRUD operations of sample Plugins I am working and sample Model files to get you started.

 ## Coming soon:

> Writing your first Model File
> [!TIP]
> It is recommended to see ModelFilesGuide.md

> Run [ModelFileWriter.bat](https://github.com/PhpCupcakeShop/ModelFileWriter), and answer prompts.

> Drag and Drop it into a new directory of your name choosing the Models Folder and then within its own Models folder.

> Open your url /admin

> Go into edit mode