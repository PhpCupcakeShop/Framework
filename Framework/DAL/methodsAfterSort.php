<?
/**
 * List of methods in the Cupcake Data Access Layer:
 * 
 * save($object);
 * Saves an object to the database. If contains an ID, will update.
 *
 * find($class, $id);
 * Retrieves an object from the database by its ID.
 *
 * findAll($class);
 * Retrieves all objects of a given class from the database.
 *
 * findAllPaginated($class,$currentPage = 1,$itemsPerPage = 10);
 * Retrieves all objects of a given class from the database with pagination.
 *
 * getTotalofAll($class);
 * Retrieves the total count of objects for a given class.
 *
 * delete($class, $id);
 * 
 * displayTable($className,$tableName);
 * displayTable Displays a table of data from the specified table.
 * 
 * createTable($object);
 * Creates a table based on the properties of the given object.
 *
 * displayTableSearch($className,$tableName,$currentPage, $itemsPerPage,$columnName = null,$searchQuery = "");
 * Displays a table with pagination and search functionality.
 * 
 * displayTablePaginated($className,$tableName,$currentPage,$itemsPerPage);
 * Displays a table with pagination.
 * 
 * getFieldNamesForAdmin($stmt);
 * Retrieves the field names for the provided database statement.
 *
 * renderTable($className, $fieldNames, $data);
 * Renders an HTML table based on the provided data.
 * 
 * getModels($namespaceDir);
 * Retrieves a list of model class names from a specified namespace directory.
 *
 * getFieldNames($stmt);
 * Retrieves the field names from a database statement.
 * 
 * searchAllTables($searchQuery,$currentPage = 1,$itemsPerPage = 10);
 * Searches all tables in the database for a given search query and returns the
 * paginated results along with the total number of pages and objects.
 *
 * getTableColumns($tableName);
 * Searches the database for a given search term, either across all tables or in
 * a specific table and column.
 * 
 * search($class,$searchTerm,$currentPage = 1,$itemsPerPage = 10,$column = null);
 * Searches for objects in the database based on a given search term and column.
 *
 * getTotalofSearch($class,$searchTerm = null,$column = null)
 * Retrieves the total count of objects for a given class based on a search term.
 *
 * DbTableOptionFields();
 * A lot of complexity here.
 * A function to select tables and columns as options for search fields.
 * Dependent on Model file searchableByAdmin and isSearchable.
 *
 * databaseSeeIfTable($tableName, $dbname);
 * databaseSeeIfTable returns a boolean of 1 if said table exists.
 * 
 * tableExists($tableName);
 * Checks if a table exists in the database.
 *
 * getConnection()
 * Retrieves a database connection.
 */
