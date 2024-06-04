<?php


include ConfigVars::getDocRoot()."/Config/conn.inc.php";

try {
  $phpcupcakeDB = new PDO("mysql:host=".HOST."", $username, $password);
  // set the PDO error mode to exception
  $phpcupcakeDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $createdb = "CREATE DATABASE " . $dbname;
  // use exec() because no results are returned
  $phpcupcakeDB->exec($createdb);
  echo "Database". $dbname. " created successfully<br>";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$phpcupcakeDB = null;