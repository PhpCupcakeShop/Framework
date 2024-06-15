<?php

namespace PhpCupcakes\DAL;

use PDO;
use PDOException;

class RelationalDAL
{
    public static function getRelatedEntities($class, $id, $entity1, $entity2)
    {
        $entityTableName = $class::getTableNames($entity1);
        $relationshipTableName = $class::getTableName();
        $entity1IdColumnName = $class::getEntityIdColumnName($entity1);
        $entity2IdColumnName = $class::getEntityIdColumnName($entity2);
        $stmt = "SELECT * 
                                   FROM {$entityTableName} as e
                                   INNER JOIN {$relationshipTableName} as r ON e.id = r.{$entity2IdColumnName}
                                   WHERE r.{$entity1IdColumnName} = :id";
                                   echo $stmt;
        $stmt = self::getConnection()->prepare($stmt);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function createRelationship($class, $entity1Id, $entity2Id)
    {
        $stmt = self::getConnection()->prepare("INSERT INTO :relationship_table (:entity1_id, :entity2_id) VALUES (:entity1_id, :entity2_id)");
        $stmt->bindValue(':relationship_table', $class::getRelationshipTableName(), PDO::PARAM_STR);
        $stmt->bindValue(':entity1_id', $class::getEntityIdColumnName('entity1'), PDO::PARAM_STR);
        $stmt->bindValue(':entity2_id', $class::getEntityIdColumnName('entity2'), PDO::PARAM_STR);
        $stmt->bindValue(':entity1_id', $entity1Id, PDO::PARAM_INT);
        $stmt->bindValue(':entity2_id', $entity2Id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateRelationship($class, $entity1Id, $entity2Id, $data)
    {
        $updateValues = "";
        foreach (array_keys($data) as $key) {
            $updateValues .= "$key = :$key, ";
        }
        $updateValues = rtrim($updateValues, ", ");

        $stmt = self::getConnection()->prepare("UPDATE :relationship_table SET $updateValues WHERE :entity1_id = :entity1_id AND :entity2_id = :entity2_id");
        $stmt->bindValue(':relationship_table', $class::getRelationshipTableName(), PDO::PARAM_STR);
        $stmt->bindValue(':entity1_id', $class::getEntityIdColumnName('entity1'), PDO::PARAM_STR);
        $stmt->bindValue(':entity2_id', $class::getEntityIdColumnName('entity2'), PDO::PARAM_STR);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':entity1_id', $entity1Id, PDO::PARAM_INT);
        $stmt->bindValue(':entity2_id', $entity2Id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function deleteRelationship($class, $entity1Id, $entity2Id)
    {
        $stmt = self::getConnection()->prepare("DELETE FROM :relationship_table WHERE :entity1_id = :entity1_id AND :entity2_id = :entity2_id");
        $stmt->bindValue(':relationship_table', $class::getRelationshipTableName(), PDO::PARAM_STR);
        $stmt->bindValue(':entity1_id', $class::getEntityIdColumnName('entity1'), PDO::PARAM_STR);
        $stmt->bindValue(':entity2_id', $class::getEntityIdColumnName('entity2'), PDO::PARAM_STR);
        $stmt->bindValue(':entity1_id', $entity1Id, PDO::PARAM_INT);
        $stmt->bindValue(':entity2_id', $entity2Id, PDO::PARAM_INT);
        $stmt->execute();
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

