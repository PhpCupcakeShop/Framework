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

> `findAllPaginated($class,$currentPage = 1,$itemsPerPage = 10);`

### Deletes a row in table with given ID

> `delete($class, $id);`

## Table Construction Mostly for Admin Portal:

### Renders an HTML table based on the provided data.

> `renderTable($className, $fieldNames, $data);`

### Displays a table of data from the specified table.

> `displayTable($className,$tableName);`

### Displays a table with pagination.

> displayTablePaginated($className,$tableName,$currentPage,$itemsPerPage);`

### Displays a table with pagination and search functionality.

> `displayTableSearch($className,$tableName,$currentPage,$itemsPerPage,$columnName = null,$searchQuery = "");` 

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchAllTables( $searchQuery,$currentPage = 1,$itemsPerPage = 10)` 

### Retrieves the field names for the provided database statement.

> `getFieldNamesForAdmin($stmt);`

## Search Methods:

### Searches the database for a given search term, either across all tables or in a specific table and column.

> `searchDatabase($searchTerm, $searchTable, $searchColumn);`

### Searches all tables in the database for a given search query and returns the paginated results along with the total number of pages and objects.

> `searchAllTables($searchQuery,$currentPage = 1,$itemsPerPage = 10);`

### Searches for objects in the database based on a given search term and column.

> `search($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null);`

### Retrieves the total count of objects for a given class based on a search term.

> `getTotalofSearch($class,$searchTerm = null,$column = null);`

### A function to select tables and columns as options for search fields.

> `DbTableOptionFields();`

> [!WARNING]
> A lot of complexity here.
> Dependent on Model file searchableByAdmin and isSearchable.

## Smaller Helper Functions

### Retrieves the total count of objects for a given class.

> `getTotalofAll($class);`

### Retrieves a list of model class names from a specified namespace directory.

> `getModels($namespaceDir);`

### Checks if a table exists in the database.

> `tableExists($tableName);`

### Searches the database for the columns of a given table.

> `getTableColumns($tableName);`

> [!DANGER]
> Deprecated. Use the one below.

### Retrieves the column names for a specified table.

> `getColumnNames($tableName);`
> 

### Retrieves the field names from a database statement.

> `getFieldNames($stmt);`

### databaseSeeIfTable returns a boolean of 1 if said table exists.

> `databaseSeeIfTable($tableName, $dbname);`

> [!DANGER]
> Deprecated. Use tableExists().

### Retrieves a database connection.

> `getConnection();`
