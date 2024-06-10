# List of methods in the Vanilla Cupcake Data Access Layer:

## Basic CRUD operations:

### Saves an object to the database. If contains an ID, will update.

> `save($object);`

### Creates a table based on the properties of the given object.

>  `createTable($object);`

### Retrieves an object from the database by its ID.

> `find($class, $id);`

### Retrieves all objects of a given class from the database.

> `findAll($class);`

### Retrieves all objects of a given class from the database with pagination.

> [!DANGER]
> Deprecating. Use one below.

> `findAllPaginated($class,$currentPage = 1,$itemsPerPage = 10);`

### Retrieves all objects of a given class from the database with pagination.

> `findAllPaginateSorted($class,$currentPage = 1,$itemsPerPage = 10);`

### Deletes a row in table with given ID

> `delete($class, $id);`

## Table Construction Mostly for Admin Portal:

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

### Renders an HTML table based on the provided data.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `renderTable($className, $fieldNames, $data);`

### Displays a table of data from the specified table.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `displayTable($className,$tableName);`

### Displays a table with pagination.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `displayTablePaginated($className,$tableName,$currentPage,$itemsPerPage);`

### Displays a table with pagination and search functionality.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `displayTableSearch($className,$tableName,$currentPage,$itemsPerPage,$columnName = null,$searchQuery = "");` 

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `searchAllTables( $searchQuery,$currentPage = 1,$itemsPerPage = 10)` 

### Retrieves the field names for the provided database statement.

> [!DANGER]
> Deprecated. Will be rebuilding the Admin Portal closer to release.

> `getFieldNamesForAdmin($stmt);`

## Search Methods:

### Searches the database for a given search term, either across all tables or in a specific table and column.

> [!DANGER]
> Deprecated. Use searchRelevancy().

> `searchDatabase($searchTerm, $searchTable, $searchColumn);`

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchAllTables($searchQuery,$currentPage = 1,$itemsPerPage = 10);`

### Searches specified table and column in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchOneTable($className,$searchQuery,$columnName,$currentPage = 1,$itemsPerPage = 10)`

### Searches the database for a given search term, either across all tables or in a specific table and column. Sorts by relevancy.

> [!NOTE]
> This is used in `searchAllTables` and `searchOneTable`, so using one of those for the frontend is recommended.

> `searchDatabaseRelevancy($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null)`
### Searches for objects in the database based on a given search term and column.

> [!DANGER]
> Deprecated.

> `search($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null);`

### Retrieves the total count of objects for a given class based on a search term.

> [!DANGER]
> Deprecated.

> `getTotalofSearch($class,$searchTerm = null,$column = null);`

### Checks if a column is marked as searchable for a given table.

> `isColumnSearchable($table, $column);`

### A function to select tables and columns as options for search fields.

> [!WARNING]
> A lot of complexity here.
> Dependent on Model file searchableByAdmin and isSearchable.

> `dbTableOptionFields();`


## Smaller Helper Functions

### Retrieves the total count of objects for a given class.

> `getTotalofAll($class);`

### Retrieves a list of model class names from a specified namespace directory.

> `getModels($namespaceDir);`

### Checks if a table exists in the database.

> `tableExists($tableName);`

### Searches the database for the columns of a given table.

> [!DANGER]
> Deprecated. Use the one below.

> `getTableColumns($tableName);`


### Retrieves the column names for a specified table.

> `getColumnNames($tableName);`

### Retrieves the field names from a database statement.

> `getFieldNames($stmt);`

### databaseSeeIfTable returns a boolean of 1 if said table exists.

> [!DANGER]
> Deprecated. Use tableExists().

> `databaseSeeIfTable($tableName, $dbname);`


### Retrieves a database connection.

> `getConnection();`
