
    <?php
    require_once '../Framework/autoload.php';      /*linkhere*/
    use PhpCupcakes\Config\ConfigVars;
    use PhpCupcakes\DAL\CupcakeDAL;
    use PhpCupcakes\Helpers\PaginationHelper; 
    use PhpCupcakes\Helpers\LoadHtml; 
    use PhpCupcakes\Helpers\FormHelper;
    ?>    
<!DOCTYPE html>
<html>
<head>
    <title>Admin Portal</title>
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css"> <!--linkhere-->
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css"> <!--linkhere-->
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
        'posturl' => ConfigVars::getSiteUrl().'/admin_portal/search.php'   
    ];  /*linkhere*/
    ?>
    <div class="search bg-info"><?= LoadHtml::loadInclude('searchform', $searchFeatureVariables); ?></div>
</header>
    <nav class="bg-success-light text-dark"><?= LoadHtml::loadInclude('adminnav'); ?>
        <?php
        $addLinks = CupcakeDAL::getModels(ConfigVars::getDocRoot().'/Models/');     /*linkhere*/
        foreach ($addLinks as $class) {
            $link = ConfigVars::getSiteUrl().'/admin_portal/addObject.php?class='. $class;     /*linkhere*/
            ?>
            <a href="<?= $link ?>">Add a <?= $class ?></a>
            <?php
        }
        ?>
        <?php
        $result = CupcakeDAL::dbTableOptionFields();
        $browseTable = $result['searchTable'];
        ?><div style="float:right;">
        <?= FormHelper::renderFormOpen('index.php', $method = 'get') ?>
        <select id="browseTable" name="browseTable">
            <?= $browseTable ?>
        </select>
        <?php
        echo FormHelper::renderSubmit('go','browseTable');
        echo FormHelper::renderFormClose();
        ?></div>
    </nav>
    <div class="mainparent">
<main>  
    <?php

    list($currentPage, $itemsPerPage) = PaginationHelper::getPaginationParams();

    if (isset($_GET['browseTable'])) {
        $class = $_GET['browseTable'];
        //when adding plugins and modules and also www this will have to load $variable\Models\$class
        $className = 'PhpCupcakes\\Models\\' . $class;
        $tableName = call_user_func([$className, 'getTableName']);
        $tableViewer = new CupcakeDAL();
        $tableViewer->displayTablePaginated($className, $tableName, $currentPage, $itemsPerPage);

        $totalObjects = $className::getTotalofAll(); 
        PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage);

    } else {
            $class = 'MyObject';  //change this to whatever default - make this customizable.
            //when adding plugins and modules and also www this will have to load $variable\Models\$class
            $className = 'PhpCupcakes\\Models\\' . $class;
            $tableName = call_user_func([$className, 'getTableName']);
            $tableViewer = new CupcakeDAL();
            $tableViewer->displayTablePaginated($className, $tableName, $currentPage, $itemsPerPage);
            $totalObjects = $className::getTotalofAll(); 
            PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage);
    
    }
    ?>
    </main>
    </div>
    </div>

</body>
</html>