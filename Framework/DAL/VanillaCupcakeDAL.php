<?php

namespace PhpCupcakes\DAL;

use PDO;
use Exception;
use PDOException;
use PDOStatement;
use PhpCupcakes\Config\ErrorReporting;
use PhpCupcakes\Config\ConfigVars;

/**
 * Class VanillaCupcakeDAL
 * @package PhpCupcakes\DAL
 *
 * This class provides data access layer functionality for the cupcake framework.
 * It handles database operations such as CRUD operations, searching, and pagination.
 */
class VanillaCupcakeDAL
{
    /**
     * Saves an object to the database.
     *
     * @param object $object The object to be saved.
     * @return object with given params.
     * @throws Exception
     */
    public static function save($object)
    {
        //Setting variables.
        //Gets a connection to the database within its own class.
        $connection = self::getConnection();
        //Sets the passed array in the function as $properties.
        $properties = get_object_vars($object);
        //Pulls the key out of key => value in the array and they are the table columns.
        $columns = array_keys($properties);
        //Loops through values within the array, so what will be the rows in the table.
        $values = array_fill(0, count($columns), "?");

        //Makes an attempt so it will spit out an error below if this doesn't work.
        try {
            //If the ID is set...
            if (isset($properties["id"])) {
                //Creates part of the sql statement for the columns and rows that need updating.
                $set = array_map(function ($column) {
                    return "$column = ?";
                }, $columns);
                //Finishes the part of sql statement with commas.
                $set = implode(", ", $set);
                //Creates the entire sql statemtent.
                $sql = "UPDATE {$object->getTableName()} SET $set WHERE id = ?";
                //Creates the parameters to bind them after the if/else.
                $params = array_merge(array_values($properties), [
                    $properties["id"],
                ]);
                //If the ID isn't set...
            } else {
                // Check if the table exists, and create it if it doesn't.
                $tableExists = self::tableExists($object->getTableName());
                if (!$tableExists) {
                    self::createTable($object);
                    //Need to add a loop to do FULLTEXT Index of all columns and of all columns.
                }
                //Creates sql statement.
                $sql =
                    "INSERT INTO {$object->getTableName()} (" .
                    implode(", ", $columns) .
                    ") VALUES (" .
                    implode(", ", $values) .
                    ")";
                //Creates parameters for binding.
                $params = array_values($properties);
            }
            //Prepares the sql statement...
            $statement = $connection->prepare($sql);
            //... and then binds the parameters and executes the statments.
            $statement->execute($params);
            //If there is a new ID return that, else return the original id.
            if (!isset($properties["id"])) {
                $object->id = $connection->lastInsertId();
            } else {
                $object->id = $properties["id"];
            }
            return $object;
            //If a database error above will say so here.
        } catch (PDOException $e) {
            $msg = "Error saving object: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        //Close the connection always mmmkay?
        $connection->close();
    }

/**
 * Creates a table based on the properties of the given object.
 *
 * @param object $object The object whose properties will be used to create the table.
 * @return void
 */
/**
 * Creates a table based on the properties of the given object.
 *
 * @param object $object The object whose properties will be used to create the table.
 * @return void
 */
private static function createTable($object)
{
    //Gets a connection to the database within its own class.
    $connection = self::getConnection();
    //Gathers the array passed through the variable.
    $properties = get_object_vars($object);
    //Gathers the table columns from above array.
    $columns = array_keys($properties);

    //Gets any set data from the model file passed through the function.
    $columnDefinitions = array_map(function ($column) use ($object) {
        $metadata = $object::$propertyMetadata[$column];
        $type = $metadata["type"];
        $length = isset($metadata["length"]) ? "($metadata[length])" : "";
        $extra = isset($metadata["extra"]) ? " $metadata[extra]" : "";
        return "$column $type$length$extra";
    }, $columns);

    //Creates SQL statement from the above definitions.
    $sql =
        "CREATE TABLE {$object->getTableName()} (" .
        implode(", ", $columnDefinitions) .
        ")";

    try {
        //Executes SQL statement.
        $connection->exec($sql);

        // Add FULLTEXT index for searchable columns
        $searchableColumns = array_filter($columns, function ($column) use ($object) {
            return $object::$propertyMetadata[$column]['searchableByAdmin'] == '1';
        });

        foreach ($searchableColumns as $column) {
            $connection->exec("ALTER TABLE {$object->getTableName()} ADD FULLTEXT INDEX `{$column}_fulltext`(`{$column}`)");
        }

        // Add FULLTEXT index for the entire searchable table
        $searchableColumnsStr = implode(",", $searchableColumns);
        $connection->exec("ALTER TABLE {$object->getTableName()} ADD FULLTEXT INDEX `{$object->getTableName()}_fulltext`($searchableColumnsStr)");
    } catch (PDOException $e) {
        $msg = "Error creating table: " . $e->getMessage();
        ErrorReporting::logError($msg);
        throw new Exception($msg);
    }
}
    /**
     * Retrieves an object from the database by its ID.
     *
     * @param string $class The class name of the object to be retrieved.
     * @param int $id The ID of the object to be retrieved.
     * @return object|null The retrieved object, or null if not found.
     */
    public static function find($class, $id)
    {
        //Gets the connection to DB
        $connection = self::getConnection();
        //Sets the SQL statement and uses the table name from the method file.
        $sql = "SELECT * FROM {$class::getTableName()} WHERE id = ?";

        try {
            //Prepares SQL statement.
            $statement = $connection->prepare($sql);
            //Binds parameter and executes statement.
            $statement->execute([$id]);
            //Gathers the result from the statment.
            //*Not really sure what the fetchObject does.
            $result = $statement->fetchObject($class);
            //Returns the result of getting the object by its ID.
            return $result;
        } catch (PDOException $e) {
            $msg = "Error finding object: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        //Close the connection to DB
        $connection->close();
    }

    /**
     * Retrieves all objects of a given class from the database.
     *
     * @param string $class The class name of the objects to be retrieved.
     * @return array An array of retrieved objects.
     */
    public static function findAll($class)
    {
        //Gets connection to DB
        $connection = self::getConnection();
        //Gets everything from the table name specified in the model file.
        $sql = "SELECT * FROM {$class::getTableName()}";
        try {
            //Prepares and executes statement.
            $statement = $connection->prepare($sql);
            $statement->execute();
            //Gets and returns the results
            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);
            return $results;
        } catch (PDOException $e) {
            $msg = "Error finding objects: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        //Close connection to DB
        $connection->close();
    }

 
    /**
     * Retrieves all objects of a given class from the database with pagination.
     *
     * @param string $class The class name of the objects to be retrieved.
     * @param int $page The current page number (starts from 1).
     * @param int $itemsPerPage The number of items to display per page.
     * @return array An array of retrieved objects.
     * @throws Exception Throws an exception if there's an error finding the objects.
     */

     public static function findAllPaginateSorted(
        $class,
        $currentPage = 1,
        $itemsPerPage = 10
    ) {
        $connection = self::getConnection();

        // Calculate the offset for the current page
        $offset = ($currentPage - 1) * $itemsPerPage;

        if (isset($_GET['browseColumn'])) {

            $sortColumn = str_replace('-', ' ', $_GET['browseColumn']);

            //Sets SQL statement for given table name from Model file, with a limit and offset.
            $sql = "SELECT * FROM {$class::getTableName()} ORDER BY ". $sortColumn ." LIMIT :itemsPerPage OFFSET :offset";

        } else {

        //Sets SQL statement for given table name from Model file, with a limit and offset.
        $sql = "SELECT * FROM {$class::getTableName()} ORDER BY id LIMIT :itemsPerPage OFFSET :offset";
        }
        try {
            //Prepares the SQL statement and binds the parameters.
            $statement = $connection->prepare($sql);
            $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
            $statement->bindParam(
                ":itemsPerPage",
                $itemsPerPage,
                PDO::PARAM_INT
            );
            //Executes statement gets and returns results.
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);
            return $results;
        } catch (PDOException $e) {
            $msg = "Error finding all objects paginated: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        //Close the MySQL connection
        $connection->close();
    }

    /**
     * Deletes an object from the database by its ID.
     *
     * @param string $class The class name of the object to be deleted.
     * @param int $id The ID of the object to be deleted.
     * @return void
     */
    public static function delete($class, $id)
    {
        //Get Connection to DB
        $connection = self::getConnection();
        //Set SQL statement for Delete operation.
        $sql = "DELETE FROM {$class::getTableName()} WHERE id = ?";
        //Set try statement so it can catch if an error.
        try {
            //Prepare SQL statement.
            $statement = $connection->prepare($sql);
            //Execute and bind parameters.
            $statement->execute([$id]);
            //Return an error message if the above statment doesn't happen.
        } catch (PDOException $e) {
            $msg = "Error deleting object: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
    }

    /**
     * Searches all tables in the database for a given search query and returns the
     * paginated results along with the total number of pages and objects.
     *
     * @param string $searchQuery The search query to use.
     * @param int $currentPage The current page number (default: 1).
     * @param int $itemsPerPage The number of items to display per page (default: 10).
     * @return array An associative array containing the paginated results, the total
     *               number of pages, and the total number of objects.
     */
    public static function searchAllTables(
        $searchQuery,
        $currentPage = 1,
        $itemsPerPage = 10
    ) {
        $searcher = new self();
        $searchResults = $searcher->searchDatabaseRelevancy(
            $searchQuery,
            "all",
            "all"
        );

        $totalResults = count($searchResults);
        $totalPages = ceil($totalResults / $itemsPerPage);

        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedResults = array_slice($searchResults, $offset, $itemsPerPage);

        // Return the paginated results along with the total pages
        return [
            "results" => $paginatedResults,
            "totalPages" => $totalPages,
            "totalObjects" => $totalResults,
        ];
    }

    public static function searchOneTable(
        $className,
        $searchQuery,
        $columnName,
        $currentPage = 1,
        $itemsPerPage = 10
    ) {
        $table = $className::getTableName();
        $searcher = new self();
        $searchResults = $searcher->searchDatabaseRelevancy(
            $searchQuery,
            $table,
            $columnName
        );

        $totalResults = count($searchResults);
        $totalPages = ceil($totalResults / $itemsPerPage);

        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedResults = array_slice($searchResults, $offset, $itemsPerPage);

        // Return the paginated results along with the total pages
        return [
            "results" => $paginatedResults,
            "totalPages" => $totalPages,
            "totalObjects" => $totalResults,
        ];
    }

    /**
     * Searches the database for a given search term, either across all tables or in
     * a specific table and column.
     *
     * @param string $searchTerm The search term to use.
     * @param string $searchTable The name of the table to search (or "all" for all tables).
     * @param string $searchColumn The name of the column to search (or "all" for all columns).
     * @return array The search results.
     */
    public function searchDatabaseRelevancy(
        $searchTerm,
        $searchTable,
        $searchColumn
    ) {
        $results = [];
        try {
            $connection = self::getConnection();

            if ($searchTable === "all") {
                // Search all tables
                $stmt = $connection->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($tables as $table) {
                    // Check if a FULLTEXT index exists on the searchable columns
                    $indexStmt = $connection->prepare(
                        "SHOW INDEX FROM `$table` WHERE Index_type = 'FULLTEXT'"
                    );
                    $indexStmt->execute();
                    $indexes = $indexStmt->fetchAll(PDO::FETCH_ASSOC);
                    $indexedColumns = array_column($indexes, "Column_name");

                    if (empty($indexedColumns)) {
                        continue; // Skip this table if there are no columns with a FULLTEXT index
                    }

                    $sql = "SELECT * FROM `$table` ";
                    $sql .= "WHERE MATCH(`";
                    $sql .= implode("`, `", $indexedColumns);
                    $sql .= "`) AGAINST(:searchTerm IN NATURAL LANGUAGE MODE)";

                    $stmt = $connection->prepare($sql);
                    $stmt->bindValue(
                        ":searchTerm",
                        $searchTerm,
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = array_merge(
                        $results,
                        $stmt->fetchAll(PDO::FETCH_ASSOC)
                    );
                }
            } elseif ($searchColumn === "all") {
                // Search all columns of the specified table
                // Check if a FULLTEXT index exists on the searchable columns for the specific table
                $indexStmt = $connection->prepare(
                    "SHOW INDEX FROM `$searchTable` WHERE Index_type = 'FULLTEXT'"
                );
                $indexStmt->execute();
                $indexes = $indexStmt->fetchAll(PDO::FETCH_ASSOC);
                $indexedColumns = array_column($indexes, "Column_name");

                if (empty($indexedColumns)) {
                    return []; // Return an empty result if there are no columns with a FULLTEXT index
                }

                $sql = "SELECT * FROM `$searchTable` ";
                $sql .= "WHERE MATCH(`";
                $sql .= implode("`, `", $indexedColumns);
                $sql .= "`) AGAINST(:searchTerm IN NATURAL LANGUAGE MODE)";

                $stmt = $connection->prepare($sql);
                $stmt->bindValue(":searchTerm", $searchTerm, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                //will someday make columns an array to search multiple.
                // Check if a FULLTEXT index exists on the searchable columns for the specific table
                $indexStmt = $connection->prepare(
                    "SHOW INDEX FROM `$searchTable` WHERE Index_type = 'FULLTEXT'"
                );
                $indexStmt->execute();
                $indexes = $indexStmt->fetchAll(PDO::FETCH_ASSOC);
                $indexedColumns = array_column($indexes, "Column_name");

                if (empty($indexedColumns)) {
                    return []; // Return an empty result if there are no columns with a FULLTEXT index
                }

                // Check if the $searchColumn is in the list of indexed columns
                if (in_array($searchColumn, $indexedColumns)) {
                    $sql = "SELECT * FROM `$searchTable` ";
                    $sql .= "WHERE MATCH(`$searchColumn`) AGAINST(:searchTerm IN NATURAL LANGUAGE MODE)";

                    $stmt = $connection->prepare($sql);
                    $stmt->bindValue(
                        ":searchTerm",
                        $searchTerm,
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    // If the $searchColumn is not indexed, perform a standard WHERE clause search
                    $sql = "SELECT * FROM `$searchTable` ";
                    $sql .= "WHERE `$searchColumn` LIKE :searchTerm";

                    $stmt = $connection->prepare($sql);
                    $stmt->bindValue(
                        ":searchTerm",
                        "%$searchTerm%",
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            $msg = "Error searching database: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        return $results;
    }

    /**
     * Checks if a column is marked as searchable for a given table.
     *
     * @param string $table The name of the table.
     * @param string $column The name of the column.
     * @return bool True if the column is searchable, false otherwise.
     */
    private function isColumnSearchable($table, $column)
    {
        $models = self::getModels(ConfigVars::getModelDir());
        foreach ($models as $model) {
            if ($model::getTableName() == $table) {
                $metadata = $model::$propertyMetadata;
                if (
                    isset($metadata[$column]) &&
                    $metadata[$column]["isSearchable"] == "1"
                ) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * A function to select tables and columns as options for search fields.
     * Dependent on Model file searchableByAdmin and isSearchable.
     * A lot of complexity here.
     *
     *
     * @return array of needed values for specific tables and columns in db.
     */
    public static function dbTableOptionFields()
    {
        global $admin, $posturl;

        if (isset($admin) && $admin == 1) {
            $searchFactor = "searchableByAdmin";
            $posturl = $posturl;
        } else {
            $searchFactor = "isSearchable";
            $posturl = ConfigVars::getWWW() . "/search.php"; /*linkhere*/
        }

        $searchTable = [];
        $searchColumn = "";
        $namespacedir = ConfigVars::getDocRoot() . "/Models/"; /*linkhere*/
        $models = self::getModels($namespacedir);

        $tableColumnMap = [];

        foreach ($models as $className) {
            // Get the table name
            //implement other model folders somehow here.
            $classNamespace = "PhpCupcakes\\Models\\" . $className;

            $tableName = $classNamespace::getTableName();
            if (self::tableExists($tableName) == true) {
                $tableColumnMap[$tableName] = [];
                // Get the column names
                $columns = self::getColumnNames($tableName);

                $searchTable[] = $className;

                foreach ($columns as $column) {
                    if (
                        $classNamespace::$propertyMetadata[$column][
                            $searchFactor
                        ] == "1"
                    ) {
                        $tableColumnMap[$className][] = $column;
                    }
                }
            }
        }

        return [
            "searchTable" => $searchTable,
            "searchColumn" => $searchColumn,
            "posturl" => $posturl,
            "tableColumnMap" => $tableColumnMap,
        ];
    }

    /******Smaller helper functions */

    /**
     * Retrieves the total count of objects for a given class.
     *
     * @param string $class The class name for which to retrieve the total count.
     * @return int The total count of objects for the specified class.
     * @throws \Exception If there is an error while executing the SQL query.
     */
    public static function getTotalofAll($class)
    {
        $connection = self::getConnection();

        $sql = "SELECT COUNT(*) AS total FROM {$class::getTableName()}";

        try {
            $statement = $connection->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return (int) $result["total"];
        } catch (PDOException $e) {
            $msg = "Error finding total of all: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        $connection->close();
    }

    /**
     * Retrieves a list of model class names from a specified namespace directory.
     *
     * @param string $namespaceDir The directory containing the model classes.
     * @return \Generator An iterator that yields the class names.
     */
    public static function getModels($namespaceDir)
    {
        $folderPath = $namespaceDir;

        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $filePath = $folderPath . "/" . $file;
                if (is_file($filePath) && substr($file, -4) === ".php") {
                    $className = substr($file, 0, -4);
                    yield $className;
                }
            }
        }
    }

    /**
     * Checks if a table exists in the database.
     *
     * @param string $tableName The name of the table to check.
     * @return bool True if the table exists, false otherwise.
     */

    public static function tableExists($tableName)
    {
        $connection = self::getConnection();
        //Creates sql statement
        $sql = "SHOW TABLES LIKE ?";

        try {
            //Prepares statement
            $statement = $connection->prepare($sql);
            //Executes statement and binds tablename parameter.
            $statement->execute([$tableName]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //Returns the result as a true or false value.
            return $result !== false;
        } catch (PDOException $e) {
            $msg = "Error checking if table exists: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
        $connection->close();
    }

    /**
     * Retrieves the column names for a specified table.
     *
     * @param string $tableName The name of the table.
     * @return array The column names.
     */
    public static function getColumnNames($tableName)
    {
        try {
            $connection = self::getConnection();
            $stmt = $connection->query("SELECT * FROM $tableName");
            $fieldNames = self::getFieldNames($stmt);
            return $fieldNames;
        } catch (PDOException $e) {
            $msg = "Error getting table column names: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
    }

    /**
     * Retrieves the field names from a database statement.
     *
     * @param PDOStatement $stmt The database statement object.
     * @return array The field names as an array.
     */
    private static function getFieldNames($stmt)
    {
        try {
            $fieldNames = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
            $stmt->execute(); // Reset the statement pointer
            return $fieldNames;
        } catch (PDOException $e) {
            $msg = "Error getting table field names: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
    }

    /**
     * Retrieves a database connection.
     *
     * @return PDO The database connection.
     */

    /*If working with more than one database, or here is an idea for scalability 
        (that isn't good enough yet for scalability yet.) 
    Add a getConnectionDbname() {} for each one, then you can use it above with 
    an if statement and the value being passed through each method of this file. */
    private static function getConnection()
    {
        try {
            //include ConfigVars::getDocRoot()."/Config/conn.inc.php";

            $cupcakeconn = new PDO(
                "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
                DBUSER,
                DBPASS
            );
            $cupcakeconn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            return $cupcakeconn;
        } catch (PDOException $e) {
            $msg = "Error connecting to database: " . $e->getMessage();
            ErrorReporting::logError($msg);
            throw new Exception($msg);
        }
    }
}
