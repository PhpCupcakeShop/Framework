 # Model Files Guide

 > The Model files are a route from the views to the data access layer. They define variables and parameters for building and accessing an associated MySQL table.  They hold the variables to looping through the FormHelper and making the pages more universal across Models/Classes.  The View Files use the Model File and its associated methods/functions. **Essentially they make the code at the data access layer _entirely reusable_, and view files _optionally reusable_.**

 ## Tell the server it's PHP

 > `<?php`

 ## Define the namespace

 > `namespace PhpCupcakes\Models;`

 ## Use the Data Access Layer

 > `use PhpCupcakes\DAL\VanillaCupcakeDAL;`

 ## Define Your Class
 
 > [!DANGER]
 
 > This should be the same as your filename without the extension (~~.php~~)

 > `class MyObject`

 > `{`

 > `//the rest of this files documentation code to be inserted here.`

 > `}`

 ## Define any Variables 
 
 > [!IMPORTANT]
 
 > These will be your table rows in the MySQL table. Fill to your own values, but leaving 'id' is highly recommended for the program to function.

 > `public $id;`

 > `public $name;`

 > `public $description;`

 ## Define the Variables for the Table and Form Fields

 > [!TIP]
 
 > More info can be found at [w3Schools](https://www.w3schools.com/mysql/mysql_datatypes.asp)

 ### Add the $propertyMetadata Variable as an Array

 > `public static $propertyMetadata = [];`

 ### Add the Above Defined Variables as the Array Keys
 
 > `public static $propertyMetadata = [`

 > `    'id' => [],`

 > `    'name' => [],`

 > `    'description' => []`

 > `];`

 ### Add Values for the Database Table Columns
 
 > `public static $propertyMetadata = [`

 > `    'id' => ['type' => 'INT',` 
   
 > `        'length' => 11,` 

 > `        'extra' => 'AUTO_INCREMENT PRIMARY KEY'],`

 > `    'name' => [ 'type' => 'VARCHAR',`
 
 > `        'length' => 255],`

 > `    'description' => ['type' => 'TEXT']`

 > `];`

 ### Add Booleans to State if Searchable and if Searchable by Admin

 > [!TIP]

 > 1 is Searchable, 0 is Not Searchable
 
 > `public static $propertyMetadata = [`

 > `    'id' => ['type' => 'INT',` 
   
 > `        'length' => 11,` 

 > `        'extra' => 'AUTO_INCREMENT PRIMARY KEY',` 

 > `        'isSearchable'=> '0',` 

 > `        'searchableByAdmin'=> '1'],`

 > `    'name' => [ 'type' => 'VARCHAR',`
 
 > `        'length' => 255,` 

 > `        'isSearchable'=> '1',` 

 > `        'searchableByAdmin'=> '1'],`

 > `    'description' => ['type' => 'TEXT',` 
 
 > `        'isSearchable'=> '1',` 
 
 > `        'searchableByAdmin'=> '1']`

 > `];`

 ### Add Form Variables to Use with the FormHelper Class (Framework\Helpers)
 
 > `public static $propertyMetadata = [`

 > `    'id' => ['type' => 'INT',` 
   
 > `        'length' => 11,` 

 > `        'extra' => 'AUTO_INCREMENT PRIMARY KEY',` 

 > `        'isSearchable'=> '0',` 

 > `        'searchableByAdmin'=> '1',` 
 
 > `        'formfield' => 'Hidden',` 
 
 > `        'placeholder' => null],`

 > `    'name' => [ 'type' => 'VARCHAR',`
 
 > `        'length' => 255,` 

 > `        'isSearchable'=> '1',` 

 > `        'searchableByAdmin'=> '1',` 

 > `        'formfield' => 'Text',` 

 > `        'placeholder' => 'choose a name'],`

 > `    'description' => ['type' => 'TEXT',` 
 
 > `        'isSearchable'=> '1',` 
 
 > `        'searchableByAdmin'=> '1',` 

 > `         'formfield' =>` 

 > `         'Textarea',` 

 > `         'placeholder' => 'write a description']`

 > `];`

 ## Add Any Values Needed Thorughout the Program for the View or Controller Files.
 
 > [!TIP]
 
 > These can be added as variables (as seen above), or added as functions (as seen below).

 > [!DANGER]
 
 > However the ones in this document should remain as variables and functions respectively for the program to work.

 ### Add a Function to Return the MySQL Table Name

 > `public static function getTableName() { return 'objects'; }`

 ### Add a Function to Return a User Friendly Name

 > `public static function getUserFriendlyName() { return 'My&nbsp;Object'; }`

 ## Add CRUD Functions/Methods

 ### Saves an object to the database. If contains an ID, will update.

 > `public function save()`
 
 > `{`
       
 > `VanillaCupcakeDAL::save($this);`
   
 > `}`

 ### Retrieves an object from the database by its ID.
 
 > `public static function find($id)`
 
 > `{`

 > `return VanillaCupcakeDAL::find(__CLASS__, $id);`

 > `}`

 ### Retrieves all objects of a given class from the database.

 > `public static function findAll()`

 > `{`
 
 >  `return VanillaCupcakeDAL::findAll(__CLASS__);`
 
 > `}`

 ### Retrieves all objects of a given class from the database with pagination.
 
 > `public static function findAllPaginated($currentPage, $itemsPerPage)`

 > `{`

 > `return VanillaCupcakeDAL::findAllPaginated(__CLASS__, $currentPage, $itemsPerPage);`

 > `}`

 ### Retrieves the total count of objects for a given class.
 
 > `public static function getTotalofAll()`

 > `{`

 > `return VanillaCupcakeDAL::getTotalofAll(__CLASS__);`

 > `}`

 ### Retrieves the total count of objects for a given class based on a search term.
 
 > `public static function getTotalofSearch($searchTerm, $column = null)`

 > `{`

 > `return VanillaCupcakeDAL::getTotalofSearch(__CLASS__, $searchTerm, $column);`

 > `}`

 ### Searches for objects in the database based on a given search term and column.
 
 > `public static function search($searchTerm, $column = null, $currentPage = 1, $itemsPerPage = 10)`

 > `{`

 > `return VanillaCupcakeDAL::search(__CLASS__, $searchTerm, $column, $currentPage, $itemsPerPage);`

 > `}`

 ### Deletes a row in table with given ID 
 
 > `public static function delete($id)`

 > `{`

 > `VanillaCupcakeDAL::delete(__CLASS__, $id);`

 > `}`

