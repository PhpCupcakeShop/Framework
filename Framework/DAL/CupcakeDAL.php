<?php

namespace PhpCupcakes\DAL;

use PDO;
use PDOException;
use PDOStatement;
use PhpCupcakes\Config\ConfigVars;
use PhpCupcakes\Helpers\FormHelper;

/**
 * Class CupcakeDAL
 * @package PhpCupcakes\DAL
 *
 * This class provides data access layer functionality for the cupcake application.
 * It handles database operations such as displaying tables, searching, and pagination.
 */
class CupcakeDAL
{
        /**
     * Saves an object to the database.
     *
     * @param object $object The object to be saved.
     * @return void
     * @throws Exception
     */
    public static function save($object)
    {
        $connection = self::getConnection();

        $properties = get_object_vars($object);
        $columns = array_keys($properties);
        $values = array_fill(0, count($columns), "?");

        try {
            if (isset($properties["id"])) {
                $set = array_map(function ($column) {
                    return "$column = ?";
                }, $columns);
                $set = implode(", ", $set);
                $sql = "UPDATE {$object->getTableName()} SET $set WHERE id = ?";
                $params = array_merge(array_values($properties), [
                    $properties["id"],
                ]);
            } else {
                // Check if the table exists, and create it if it doesn't
                $tableExists = self::tableExists($object->getTableName());
                if (!$tableExists) {
                    self::createTable($object);
                }

                $sql =
                    "INSERT INTO {$object->getTableName()} (" .
                    implode(", ", $columns) .
                    ") VALUES (" .
                    implode(", ", $values) .
                    ")";
                $params = array_values($properties);
            }

            $statement = $connection->prepare($sql);
            $statement->execute($params);

            if (!isset($properties["id"])) {
                $object->id = $connection->lastInsertId();
            } else {
                $object->id = $properties["id"];
            }
            return $object;
        } catch (PDOException $e) {
            throw new Exception("Error saving object: " . $e->getMessage());
        }
        $connection->close();
    }

    /**
     * Checks if a table exists in the database.
     *
     * @param string $tableName The name of the table to check.
     * @return bool True if the table exists, false otherwise.
     */
    private static function tableExists($tableName)
    {
        $connection = self::getConnection();
        $sql = "SHOW TABLES LIKE ?";

        try {
            $statement = $connection->prepare($sql);
            $statement->execute([$tableName]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result !== false;
        } catch (PDOException $e) {
            throw new Exception(
                "Error checking table existence: " . $e->getMessage()
            );
        }
        $connection->close();
    }

    /**
     * Creates a table based on the properties of the given object.
     *
     * @param object $object The object whose properties will be used to create the table.
     * @return void
     */
    private static function createTable($object)
    {
        $connection = self::getConnection();
        $properties = get_object_vars($object);
        $columns = array_keys($properties);

        $columnDefinitions = array_map(function ($column) use ($object) {
            $metadata = $object::$propertyMetadata[$column];
            $type = $metadata["type"];
            $length = isset($metadata["length"]) ? "($metadata[length])" : "";
            $extra = isset($metadata["extra"]) ? " $metadata[extra]" : "";
            return "$column $type$length$extra";
        }, $columns);

        $sql =
            "CREATE TABLE {$object->getTableName()} (" .
            implode(", ", $columnDefinitions) .
            ")";

        try {
            $connection->exec($sql);
        } catch (PDOException $e) {
            throw new Exception("Error creating table: " . $e->getMessage());
        }
        $connection->close();
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
        $connection = self::getConnection();
        $sql = "SELECT * FROM {$class::getTableName()} WHERE id = ?";

        try {
            $statement = $connection->prepare($sql);
            $statement->execute([$id]);
            $result = $statement->fetchObject($class);
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error finding object: " . $e->getMessage());
        }
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
        $connection = self::getConnection();
        $sql = "SELECT * FROM {$class::getTableName()}";
        try {
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);
            return $results;
        } catch (PDOException $e) {
            throw new Exception("Error finding objects: " . $e->getMessage());
        }
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

    public static function findAllPaginated(
        $class,
        $currentPage = 1,
        $itemsPerPage = 10
    ) {
        $connection = self::getConnection();

        // Calculate the offset for the current page
        $offset = ($currentPage - 1) * $itemsPerPage;

        $sql = "SELECT * FROM {$class::getTableName()} ORDER BY id LIMIT :itemsPerPage OFFSET :offset";

        try {
            $statement = $connection->prepare($sql);
            $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
            $statement->bindParam(
                ":itemsPerPage",
                $itemsPerPage,
                PDO::PARAM_INT
            );
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);
            return $results;
        } catch (PDOException $e) {
            throw new Exception("Error finding objects: " . $e->getMessage());
        }
        $connection->close();
    }

    /**
     * displayTable Displays a table of data from the specified table.
     *
     * @param string $className The name of the class associated with the table.
     * @param string $tableName The name of the database table to display.
     *
     * @throws PDOException If there is an error executing the database query.
     */

    public function displayTable($className, $tableName)
    {
        try {
            $connection = self::getConnection();
            $stmt = $connection->query("SELECT * FROM $tableName");
            $fieldNames = $this->getFieldNamesForAdmin($stmt);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->renderTable($className, $fieldNames, $data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Displays a table with pagination and search functionality.
     *
     * @param string $className The name of the class that will be used to render the table.
     * @param string $tableName The name of the database table to display.
     * @param int $currentPage The current page number for pagination.
     * @param int $itemsPerPage The number of items to display per page.
     * @param string|null $columnName The name of the column to search, or 'all' to search all columns.
     * @param string $searchQuery The search query to filter the table data.
     * @return int The total number of rows in the table.
     */
    public function displayTableSearch(
        $className,
        $tableName,
        $currentPage,
        $itemsPerPage,
        $columnName = null,
        $searchQuery = ""
    ) {
        try {
            $whereClause = "";
            $fieldNames = $this->getTableColumns($tableName);

            if ($columnName === null || $columnName === "all") {
                // Search all columns
                $columnDefinitions = array_map(function ($column) use (
                    $searchQuery
                ) {
                    return "`$column` LIKE :searchQuery";
                }, $fieldNames);
                $whereClause = "WHERE " . implode(" OR ", $columnDefinitions);
            } else {
                // Search a specific column
                $whereClause = "WHERE `$columnName` LIKE :searchQuery";
            }

            // Get the total number of rows
            $connection = self::getConnection();
            $stmt = $connection->prepare(
                "SELECT COUNT(*) FROM $tableName $whereClause"
            );
            $stmt->bindValue(
                ":searchQuery",
                "%" . $searchQuery . "%",
                PDO::PARAM_STR
            );
            $stmt->execute();
            $totalRows = (int) $stmt->fetchColumn();

            // Calculate the offset and limit for pagination
            $offset = ($currentPage - 1) * $itemsPerPage;
            $limit = $itemsPerPage;

            // Fetch the data with pagination and search
            $columnsStr = implode(
                ", ",
                array_map(function ($column) {
                    return "`$column`";
                }, $fieldNames)
            );
            $stmt = $connection->prepare(
                "SELECT $columnsStr FROM $tableName $whereClause LIMIT :limit OFFSET :offset"
            );
            $stmt->bindValue(
                ":searchQuery",
                "%" . $searchQuery . "%",
                PDO::PARAM_STR
            );
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Render the table
            $this->renderTable($className, $fieldNames, $data);

            return $totalRows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    /**
     * Displays a table with pagination.
     *
     * @param string $className The name of the class that will be used to render the table.
     * @param string $tableName The name of the database table to display.
     * @param int $currentPage The current page number for pagination.
     * @param int $itemsPerPage The number of items to display per page.
     * @return int The total number of rows in the table.
     */
    public function displayTablePaginated(
        $className,
        $tableName,
        $currentPage,
        $itemsPerPage
    ) {
        try {
            $connection = self::getConnection();
            // Get the total number of rows
            $stmt = $connection->query("SELECT COUNT(*) FROM $tableName");
            $totalRows = (int) $stmt->fetchColumn();

            // Calculate the offset and limit for pagination
            $offset = ($currentPage - 1) * $itemsPerPage;
            $limit = $itemsPerPage;

            // Fetch the data with pagination
            $stmt = $connection->prepare(
                "SELECT * FROM $tableName LIMIT :limit OFFSET :offset"
            );
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
            $stmt->execute();
            $fieldNames = $this->getFieldNamesForAdmin($stmt);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Render the table
            $this->renderTable($className, $fieldNames, $data);

            return $totalRows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    /**
     * Retrieves the field names for the provided database statement.
     *
     * @param PDOStatement $stmt The database statement object.
     * @return array The field names as an array.
     */
    private function getFieldNamesForAdmin($stmt)
    {
        try {
        $fieldNames = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
        $stmt->execute(); // Reset the statement pointer
        return $fieldNames;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Renders an HTML table based on the provided data.
     *
     * @param string $className The class name associated with the data.
     * @param array $fieldNames The field names to display in the table.
     * @param array $data The data to be displayed in the table.
     * @return void
     */
    private function renderTable($className, $fieldNames, $data)
    {
        ob_start(); ?>
        <table border="2">
        <thead><tr>
            <?php foreach ($fieldNames as $fieldName) { ?>
            <th><?= $fieldName ?></th>
            <?php } ?>
        <th>edit</th><th>delete</th></tr></thead>
        <tbody>
        <?php foreach ($data as $row) { ?>
            <tr>
            <?php foreach ($row as $key => $value) { ?>
                <td><?= $value ?></td>
                <?php } ?>
            <td><button id="edit-btn-<?= $row[
                "id"
            ] ?>" class='edit-btn' data-id='<?= $row[
    "id"
] ?>'>Edit</button></td>
        <script>
          let toggleCustomFieldLink = document.getElementById('edit-btn-<?= $row[
              "id"
          ] ?>');
          let customFieldElement = document.getElementById('edit-form-row-<?= $row[
              "id"
          ] ?>');
            toggleCustomFieldLink.addEventListener('click', function(event) {
              isCustomFieldVisible = !isCustomFieldVisible;
              customFieldElement.style.display = isCustomFieldVisible ? 'block' : 'none';
        })
        </script>
            <td><button class='delete-btn' data-id='<?= $row[
                "id"
            ] ?>'>Delete</button></td>
            </tr>
            <tr class='edit-form-row-<?= $row["id"] ?>' data-id='<?= $row[
    "id"
] ?>'>
            <form class='edit-form' data-id='<?= $row["id"] ?>'>
                <?php foreach ($fieldNames as $fieldName) {

                    $metadata = $className::$propertyMetadata[$fieldName];
                    $type = $metadata["formfield"];
                    ?>
                    <td>
                        <?php
                        if ($fieldName == "id") {
                        } else {
                             ?>
                            <label for='<?= $fieldName ?>'><?= $fieldName ?>:</label>
                            <?php
                        }
                        $formFunction = "render" . $type;
                        echo FormHelper::$formFunction(
                            $fieldName,
                            $row[$fieldName],
                            ["" => "required"]
                        );
                        ?>
                    </td>
                    <?php
                } ?>
                <td colspan="2"><button type='submit' class='btn btn-primary'>Save</button></td>
            </form>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    
    
        <?php
        $table = ob_get_clean();
        //need to change this to return table
        echo $table;
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
            echo "Error: " . $e->getMessage();
            return [];
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
        $fieldNames = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
        $stmt->execute(); // Reset the statement pointer
        return $fieldNames;
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
        $searchResults = $searcher->searchDatabase($searchQuery);

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
     * Retrieves the column names for a given table.
     *
     * @param string $tableName The name of the table.
     * @return array The column names for the specified table.
     */
    public static function getTableColumns($tableName)
    {
        $connection = self::getConnection();
        $stmt = $connection->prepare("SHOW COLUMNS FROM $tableName");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $columns;
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
    public function searchDatabase($searchTerm, $searchTable, $searchColumn)
    {
        $results = [];
        try {
            $connection = self::getConnection();

            if ($searchTable === "all") {
                // Search all tables
                $stmt = $connection->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($tables as $table) {
                    $stmt = $connection->prepare(
                        "SELECT * FROM `$table` WHERE 1=1"
                    );
                    $stmt->bindValue(
                        ":searchTerm",
                        "%" . $searchTerm . "%",
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = array_merge(
                        $results,
                        $stmt->fetchAll(PDO::FETCH_ASSOC)
                    );
                }
            } else {
                // Search a specific table
                $stmt = $connection->prepare(
                    "SELECT * FROM `$searchTable` WHERE 1=1"
                );

                if ($searchColumn === "all") {
                    // Search all columns
                    $stmt->bindValue(
                        ":searchTerm",
                        "%" . $searchTerm . "%",
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = array_merge(
                        $results,
                        $stmt->fetchAll(PDO::FETCH_ASSOC)
                    );
                } else {
                    // Search a specific column
                    $stmt->bindValue(
                        ":searchTerm",
                        "%" . $searchTerm . "%",
                        PDO::PARAM_STR
                    );
                    $stmt->execute();
                    $results = array_merge(
                        $results,
                        $stmt->fetchAll(PDO::FETCH_ASSOC)
                    );
                }
            }
        } catch (PDOException $e) {
            echo "Error searching database: " . $e->getMessage();
        }
        return $results;
    }

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
        } catch (\PDOException $e) {
            throw new \Exception(
                "Error finding object amount: " . $e->getMessage()
            );
        }
        $connection->close();
    }

    /**
     * Searches for objects in the database based on a given search term and column.
     *
     * @param string $class The class name of the objects to be searched.
     * @param string $searchTerm The search term to look for.
     * @param string|null $column The column to search in (or null for all columns).
     * @param int $currentPage The current page number (starts from 1).
     * @param int $itemsPerPage The number of items to display per page.
     * @return array An array of retrieved objects.
     * @throws Exception Throws an exception if there's an error finding the objects.
     */
    public static function search(
        $class,
        $searchTerm,
        $currentPage = 1,
        $itemsPerPage = 10,
        $column = null
    ) {
        $connection = self::getConnection();

        // Calculate the offset for the current page
        $offset = ($currentPage - 1) * $itemsPerPage;

        $sql = "SELECT * FROM {$class::getTableName()} WHERE ";

        if ($column === null || $column === "all") {
            // Search all columns
            $columnDefinitions = array_map(function ($property) use ($class) {
                $metadata = $class::$propertyMetadata[$property];
                return "$property LIKE :searchTerm";
            }, array_keys($class::$propertyMetadata));
            $sql .= implode(" OR ", $columnDefinitions);
        } else {
            // Search a specific column
            $sql .= "$column LIKE :searchTerm";
        }

        $sql .= " ORDER BY id LIMIT :itemsPerPage OFFSET :offset";

        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(
                ":searchTerm",
                "%" . $searchTerm . "%",
                PDO::PARAM_STR
            );
            $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
            $statement->bindParam(
                ":itemsPerPage",
                $itemsPerPage,
                PDO::PARAM_INT
            );
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);
            return $results;
        } catch (PDOException $e) {
            throw new Exception("Error searching objects: " . $e->getMessage());
        }
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
        $connection = self::getConnection();
        $sql = "DELETE FROM {$class::getTableName()} WHERE id = ?";
        try {
            $statement = $connection->prepare($sql);
            $statement->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error deleting object: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the total count of objects for a given class based on a search term.
     *
     * @param string $class The class name for which to retrieve the total count.
     * @param string|null $searchTerm The search term to use for the query. If not provided, all objects will be counted.
     * @param string|null $column The specific column to search on. If not provided or set to "all", all columns will be searched.
     * @return int The total count of objects matching the search criteria.
     * @throws Exception If there is an error while executing the SQL query.
     */
    public static function getTotalofSearch(
        $class,
        $searchTerm = null,
        $column = null
    ) {
        $connection = self::getConnection();

        $sql = "SELECT COUNT(*) FROM {$class::getTableName()} WHERE ";

        if ($column === null || $column === "all") {
            // Search all columns
            $columnDefinitions = array_map(function ($property) use ($class) {
                $metadata = $class::$propertyMetadata[$property];
                return "$property LIKE :searchTerm";
            }, array_keys($class::$propertyMetadata));
            $sql .= implode(" OR ", $columnDefinitions);
        } else {
            // Search a specific column
            $sql .= "$column LIKE :searchTerm";
        }

        try {
            $statement = $connection->prepare($sql);
            $statement->bindValue(
                ":searchTerm",
                "%" . $searchTerm . "%",
                PDO::PARAM_STR
            );
            $statement->execute();
            $total = $statement->fetchColumn();
            return $total;
        } catch (PDOException $e) {
            throw new Exception(
                "Error getting total objects: " . $e->getMessage()
            );
        }
        $connection->close();
    }

    /**
     * A lot of complexity here.
     * A function to select tables and columns as options for search fields.
     * Dependent on Model file searchableByAdmin and isSearchable.
     *
     *
     * @return array of needed values for specific tables and columns in db.
     */
    public static function DbTableOptionFields()
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
        $namespacedir = ConfigVars::getModelDir(); /*linkhere*/
        $models = self::getModels($namespacedir);

        $tableColumnMap = [];

        foreach ($models as $className) {
            // Get the table name
            //implement other model folders somehow here.
            $classNamespace = "PhpCupcakes\\Models\\" . $className;

            $tableName = $classNamespace::getTableName();
            if (self::databaseSeeIfTable($tableName, DBNAME) == 1) {
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
        $connection->close();
    }

    /**
     * databaseSeeIfTable returns a boolean of 1 if said table exists.
     *
     * @param string $tableName.
     * @return boolean 1 if table exists. 0 if table needs made elsewhere.
     */
    public static function databaseSeeIfTable($tableName, $dbname)
    {
        $bool = 1;

        try {
            //unlike the other functions this is needed here as it specifies the database name below
            //include ConfigVars::getDocRoot()."/Config/conn.inc.php";

            $table_name = $tableName;
            $connection = self::getConnection();

            $sql =
                "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = :table_name AND TABLE_SCHEMA = :dbname";

            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":table_name", $table_name);
            $stmt->bindParam(":dbname", $dbname);
            $stmt->execute();

            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $bool = 1;
            } else {
                $bool = 0;
            }
            return $bool;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Retrieves a database connection.  //TODO, include conn.inc.php instead of having conn info here
     *
     * @return PDO The database connection.
     */
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
            throw new Exception(
                "Error connecting to database: " . $e->getMessage()
            );
        }
    }
}
