<?php

require_once '../Framework/autoload.php';    /*linkhere*/
use PhpCupcakes\Helpers\FormHelper;
use PhpCupcakes\Helpers\LoadHtml;
use PhpCupcakes\Config\ConfigVars;
use PhpCupcakes\DAL\VanillaCupcakeDAL;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Portal</title>
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css">    <!--linkhere-->
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css">    <!--linkhere-->
    <style>
  
    </style>
</head>
<body>
<div class="container">
    <header>
    <h1>Admin Portal</h1>
    <?php
    $searchFeatureVariables = [
        'admin' => '1',
        'posturl' => ConfigVars::getSiteUrl().'/admin_portal/search.phtml'    /*linkhere*/
    ];
    ?>
    <div class="search bg-info"><?= LoadHtml::loadInclude('searchform', $searchFeatureVariables); ?></div>
</header>
    <nav class="bg-success-light text-dark"><?= LoadHtml::loadInclude('adminnav'); ?>
        <?php
        $addLinks = VanillaCupcakeDAL::getModels(ConfigVars::getDocRoot().'/Models/');    /*linkhere*/
        foreach ($addLinks as $class) {
            $link = ConfigVars::getSiteUrl().'/admin_portal/addObject.phtml?className='. $class;    /*linkhere*/
            ?>
            <a href="<?= $link ?>"><?= $class ?></a>
            <?php
        }
        ?></nav>
    <div class="mainparent">
<main>
    <?php

    $className = $_GET['class'];

    // Render the form open tag
    echo FormHelper::renderFormOpen('addObject.php', 'post', ['class' => 'form-horizontal']);    /*linkhere*/

     //   if (isset($_GET['$className'])) { echo 'hi '; }
    
     $className = 'PhpCupcakes\\Models\\' . $className;

     foreach ($className::$propertyMetadata as $columnName => $metadata) {
        $renderFormField = 'render' . $metadata['formfield'];
        $placeholder = $metadata['placeholder'];
        echo FormHelper::$renderFormField($columnName, '', ['class' => 'form-control', 'placeholder'=> $placeholder]);
    }

    // Render the submit button
    echo FormHelper::renderSubmit('Submit', 'submit', ['class' => 'btn btn-primary']);

    // Render the form close tag
    echo FormHelper::renderFormClose();

    ?>
</main></div>
</div></body>
</html>