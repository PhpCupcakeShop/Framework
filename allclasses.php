<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Framework/autoload.php"; /*linkhere*/

use PhpCupcakes\Config\ConfigVars;
use PhpCupcakes\Config\Analytics;
use PhpCupcakes\Helpers\GetModels;
use PhpCupcakes\DAL\VanillaCupcakeDAL;
use Objects\Models\MyCategory;
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="description" content="PHP Cupcake Shop Framework Demo">
 <meta name="keywords" content="PHP, Framework, Demo">
  <meta name="author" content="aemegi">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Analytics::Google() ?>
    <title>PHPCupcakes Example</title>
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css">   <!--linkhere--> 
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css">  <!--linkhere--> 
</head>
<body>


<div class="mainparent">
    <main>
<?php

$myObject = new MyCategory();
$myObject->fullTextIndex();

/*
    $models = GetModels::returnAllModelNamespaces();

    foreach ($models as $model) {
        $model::findAll();
    }

    $objectsTableName = VanillaCupcakeDAL::returnModelNamespaceFromTableName('objects');
    echo $objectsTableName;

    */
?>
</main>
</div>
</div>
</body>
</html>