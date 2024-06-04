<?php

require_once '../Framework/autoload.php';    /*linkhere*/


    use PhpCupcakes\Helpers\PaginationHelper;
    use PhpCupcakes\Helpers\UrlHelper;
    use PhpCupcakes\Helpers\LoadHtml;
    use PhpCupcakes\DAL\CupcakeDAL;
    use PhpCupcakes\Config\ConfigVars;


?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Search Results</title>
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css">   <!--linkhere--> 
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css">  <!--linkhere-->  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
    </head>
    <body>
        <div class="container">
            <header>
                <?php 
                $h1 = 'Search Results';
                echo LoadHtml::loadInclude('header', ['h1' => $h1]);
                ?>
            <div class="search bg-info"><?= LoadHtml::loadInclude('searchform'); ?></div>
</header>
    <nav class="bg-success-light text-dark"><?= LoadHtml::loadInclude('nav'); ?>
    <?php 

use PhpCupcakes\EditMode\EditLink;
echo EditLink::displayEditModeNav();
echo EditLink::displayEditLink();


?></nav>
    <div class="mainparent">
    <main> <?php




$searchTerm = isset($_GET['searchTerm']) && $_GET['searchTerm'] !== '';
$searchTable = isset($_GET['searchTable']) && $_GET['searchTable'] !== '';
$searchColumn = isset($_GET['searchColumn']) && $_GET['searchColumn'] !== '';

if ($_GET['searchTable'] == 'all') {
    // Get the current page and items per page from the URL parameters
    list($currentPage, $itemsPerPage) = PaginationHelper::getPaginationParams();

    $searchQuery = $_GET['searchTerm'];

    $result = CupcakeDAL::searchAllTables($searchQuery, $currentPage, $itemsPerPage);
    $allResults = $result['results'];
    $totalObjects = $result['totalObjects'];

    ?><h5>Search for '<?= $searchQuery ?>' across all tables</h5><?php
    // Display the combined search results

        ?><div style="display: flex; flex-direction: column;">
        <?php
    foreach ($allResults as $result) {
        foreach ($result as $key => $value) {
        ?>
        
        <div style="display: flex; flex-direction: row; padding: 20px;">
            <div class="quickpadding"><?= $key ?>: <?= $value ?></div>
        </div>
            <?php
        if ($key == 'id') {
            echo LoadHtml::loadComponent('/editmode/displayEdit', ['id' => $value, 'type' => $_GET['searchTable']]);
        }

        }
    }
    ?>
        </div>
        <?php

    // Display the pagination links
    PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage);
} elseif ($searchTerm && $searchTable && $searchColumn) {

    // Get the current page and items per page from the URL parameters
    list($currentPage, $itemsPerPage) = PaginationHelper::getPaginationParams();
    

    $searchQuery = $_GET['searchTerm'];
    $dataColumn = $_GET['searchColumn'];
    // Search all columns for "cupcake"

    $classNamespace = 'PhpCupcakes\\Models\\' . $_GET['searchTable'];
    $tableName = $classNamespace::getTableName();

    $objects = $classNamespace::search($searchQuery, $currentPage, $itemsPerPage, $dataColumn);


    ?><h5>Search for <?= $dataColumn ?>s in <?= $_GET['searchTable'] ?> that matches '<?= $searchQuery ?>'</h5><?php
    
    // Display the objects
// Display the objects
foreach ($objects as $object) {
    ?>
    <div style="display: flex; flex-direction: row; padding: 20px;">
        <div class="quickpadding">Name: <a href="<?= UrlHelper::routedUrl('view', $_GET['searchTable'], $object->id) ?>"><?= $object->name ?></a></div>
        <div class="quickpadding">Description: <?= $object->description ?></div>
        <?php
        echo LoadHtml::loadComponent('/editmode/displayEdit', ['id' => $object->id, 'type' => $_GET['searchTable']]);
        ?>
    </div>
    <?php
}
    // Display the pagination links
    $totalObjects = $classNamespace::getTotalofSearch($searchQuery, $dataColumn);
    PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage);
} else {
    echo "Please try your search again.";
}
    ?>

</main>
</div>
</div>
</body>
</html>