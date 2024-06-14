<<<<<<< Updated upstream
# List of methods in the Vanilla Cupcake Data Access Layer:

> [!WARNING]
> 
> The methods contained in this file are mostly routed through the Model files. Please see the guide to Model files. To use on the front end, see the CRUD operations guide.

## Basic CRUD operations:

### Saves an object to the database. If contains an ID, will update.

> `save($object);`

* @param `object` $object The object to be saved.

* @return object with given params.

### Creates a table based on the properties of the given object.

>  `createTable($object);`

* @param `object` $object The object whose properties will be used to create the table.

* @return `void`

### Retrieves an object from the database by its ID.

> `find($class, $id);`

* @param `string` $class The class name of the object to be retrieved.

* @param `int` $id The ID of the object to be retrieved.

* @return `object|null` The retrieved object, or null if not found.

### Retrieves all objects of a given class from the database.

> `findAll($class);`

* @param `string` $class The class name of the objects to be retrieved.

* @return `array` An array of retrieved objects.

### Retrieves all objects of a given class from the database with pagination.

> `findAllPaginateSorted($class,$currentPage = 1,$itemsPerPage = 10);`

* @param `string` $class The class name of the objects to be retrieved.

* @param `int` $page The current page number (starts from 1).

* @param `in` $itemsPerPage The number of items to display per page.

* @return `array` An array of retrieved objects.

### Deletes a row in table with given ID

> `delete($class, $id);`

* @param `string` $class The class name of the object to be deleted.

* @param `int` $id The ID of the object to be deleted.

* @return `void`

### Gets the related entities of a relational database tables values.

> `getRelatedEntities($class, $id, $entity1, $entity2);`

* @param `string` $class The class name of the objects to be retrieved.

* @param `int` $id The id of the object to find all relations to.

* @param `string` $entity1 an identifier set in the model file for the data matched to the id above.

* @param `string` $entity2 an identifier set in the model file for what to retrieve.

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchAllTables($searchQuery,$currentPage = 1,$itemsPerPage = 10);`

* @param `string` $searchQuery The search query to use.

* @param `int` $currentPage The current page number (default: 1).

* @param `int` $itemsPerPage The number of items to display per page (default: 10).

* @return `array` An associative array containing the paginated results, the total number of pages, and the total number of objects.

### Searches specified table and column in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchOneTable($className,$searchQuery,$columnName,$currentPage = 1,$itemsPerPage = 10)`

- @param `string` $class The class name of the objects to be retrieved.

- @param `string` $searchQuery The search query to use.

- @param `string` $columnName The name of the column to be searched, can use 'all'

- @param `int` $currentPage The current page number (default: 1).

- @param `int` $itemsPerPage The number of items to display per page (default: 10).

- @return `array` An associative array containing the paginated results, the total number of pages, and the total number of objects.

### Searches the database for a given search term, either across all tables or in a specific table and column. Sorts by relevancy.

> [!NOTE]
> This is used in `searchAllTables` and `searchOneTable`, so using one of those for the frontend is recommended. Need to update to apply the model variable as to whether or not the column is searchable, or searchable by admin.

> `searchDatabaseRelevancy($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null)`

- @param `string` $class The class name of the objects to be retrieved.
* @param `string` $searchTerm The search term to use.

* @param `string` $searchTable The name of the table to search (or "all" for all tables).

* @param `string` $searchColumn The name of the column to search (or "all" for all columns).

* @return `array` The search results.

### Checks if a column is marked as searchable for a given table.

> `isColumnSearchable($table, $column);`

* @param `string` $table The name of the table.

* @param `string` $column The name of the column.

* @return `bool` True if the column is searchable, false otherwise.

### A function to select tables and columns as options for search fields.

> [!WARNING]
> A lot of complexity here.
> Dependent on Model file searchableByAdmin and isSearchable.

> `dbTableOptionFields();`

* @return `array` of needed values for specific tables and columns in db.

## Smaller Helper Functions

### Retrieves the total count of objects for a given class.

> `getTotalofAll($class);`

* @param `string` $class The class name for which to retrieve the total count.

* @return `int` The total count of objects for the specified class.

### Checks if a table exists in the database.

> `tableExists($tableName);`

* @param `string` $tableName The name of the table to check.

* @return `bool` True if the table exists, false otherwise.

### Retrieves the column names for a specified table.

> `getColumnNames($tableName);`

* @param `string` $tableName The name of the table.

* @return `array` The column names.

### Retrieves the field names from a database statement.

> `getFieldNames($stmt);`

* @param `PDOStatement` $stmt The database statement object.

* @return `array` The field names as an array.

### Checks if a database is empty by retrieving the available models.

> [!WARNING]
> 
> Does not check full database, simply checks for entries with specified Model files. Currently used for preventing a bug, to be updated to check for all model files later.

> `isDatabaseEmpty();`

* @return `bool` True if the database is empty, false otherwise.

### Retrieves a database connection.

> `getConnection();`

* @return `PDO` The database connection.
=======
# List of methods in the Vanilla Cupcake Data Access Layer:

> [!WARNING]
> 
> The methods contained in this file are mostly routed through the Model files. Please see the guide to Model files. To use on the front end, see the CRUD operations guide.

## Basic CRUD operations:

### Saves an object to the database. If contains an ID, will update.

> `save($object);`

* @param `object` $object The object to be saved.

* @return object with given params.

### Creates a table based on the properties of the given object.

>  `createTable($object);`

* @param `object` $object The object whose properties will be used to create the table.

* @return `void`

### Retrieves an object from the database by its ID.

> `find($class, $id);`

* @param `string` $class The class name of the object to be retrieved.

* @param `int` $id The ID of the object to be retrieved.

* @return `object|null` The retrieved object, or null if not found.

### Retrieves all objects of a given class from the database.

> `findAll($class);`

* @param `string` $class The class name of the objects to be retrieved.

* @return `array` An array of retrieved objects.

### Retrieves all objects of a given class from the database with pagination.

> `findAllPaginateSorted($class,$currentPage = 1,$itemsPerPage = 10);`

* @param `string` $class The class name of the objects to be retrieved.

* @param `int` $page The current page number (starts from 1).

* @param `in` $itemsPerPage The number of items to display per page.

* @return `array` An array of retrieved objects.

### Deletes a row in table with given ID

> `delete($class, $id);`

* @param `string` $class The class name of the object to be deleted.

* @param `int` $id The ID of the object to be deleted.

* @return `void`

### Gets the related entities of a relational database tables values.

> `getRelatedEntities($class, $id, $entity1, $entity2);`

* @param `string` $class The class name of the objects to be retrieved.

* @param `int` $id The id of the object to find all relations to.

* @param `string` $entity1 an identifier set in the model file for the data matched to the id above.

* @param `string` $entity2 an identifier set in the model file for what to retrieve.

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchAllTables($searchQuery,$currentPage = 1,$itemsPerPage = 10);`

* @param `string` $searchQuery The search query to use.

* @param `int` $currentPage The current page number (default: 1).

* @param `int` $itemsPerPage The number of items to display per page (default: 10).

* @return `array` An associative array containing the paginated results, the total number of pages, and the total number of objects.

### Searches specified table and column in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchOneTable($className,$searchQuery,$columnName,$currentPage = 1,$itemsPerPage = 10)`

- @param `string` $class The class name of the objects to be retrieved.

- @param `string` $searchQuery The search query to use.

- @param `string` $columnName The name of the column to be searched, can use 'all'

- @param `int` $currentPage The current page number (default: 1).

- @param `int` $itemsPerPage The number of items to display per page (default: 10).

- @return `array` An associative array containing the paginated results, the total number of pages, and the total number of objects.

### Searches the database for a given search term, either across all tables or in a specific table and column. Sorts by relevancy.

> [!NOTE]
> This is used in `searchAllTables` and `searchOneTable`, so using one of those for the frontend is recommended. Need to update to apply the model variable as to whether or not the column is searchable, or searchable by admin.

> `searchDatabaseRelevancy($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null)`

- @param `string` $class The class name of the objects to be retrieved.
* @param `string` $searchTerm The search term to use.

* @param `string` $searchTable The name of the table to search (or "all" for all tables).

* @param `string` $searchColumn The name of the column to search (or "all" for all columns).

* @return `array` The search results.

### Checks if a column is marked as searchable for a given table.

> `isColumnSearchable($table, $column);`

* @param `string` $table The name of the table.

* @param `string` $column The name of the column.

* @return `bool` True if the column is searchable, false otherwise.

### A function to select tables and columns as options for search fields.

> [!WARNING]
> A lot of complexity here.
> Dependent on Model file searchableByAdmin and isSearchable.

> `dbTableOptionFields();`

* @return `array` of needed values for specific tables and columns in db.

## Smaller Helper Functions

### Retrieves the total count of objects for a given class.

> `getTotalofAll($class);`

* @param `string` $class The class name for which to retrieve the total count.

* @return `int` The total count of objects for the specified class.

### Checks if a table exists in the database.

> `tableExists($tableName);`

* @param `string` $tableName The name of the table to check.

* @return `bool` True if the table exists, false otherwise.

### Retrieves the column names for a specified table.

> `getColumnNames($tableName);`

* @param `string` $tableName The name of the table.

* @return `array` The column names.

### Retrieves the field names from a database statement.

> `getFieldNames($stmt);`

* @param `PDOStatement` $stmt The database statement object.

* @return `array` The field names as an array.

### Checks if a database is empty by retrieving the available models.

> [!WARNING]
> 
> Does not check full database, simply checks for entries with specified Model files. Currently used for preventing a bug, to be updated to check for all model files later.

> `isDatabaseEmpty();`

* @return `bool` True if the database is empty, false otherwise.

### Retrieves a database connection.

> `getConnection();`

* @return `PDO` The database connection.
>>>>>>> Stashed changes
