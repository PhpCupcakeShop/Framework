<?php

require_once '../Framework/autoload.php';     /*linkhere*/


    use PhpCupcakes\Helpers\PaginationHelper;
    // use PhpCupcakes\Helpers\UrlHelper;
    use PhpCupcakes\Helpers\LoadHtml;
    use PhpCupcakes\DAL\CupcakeDAL;
    use PhpCupcakes\Config\ConfigVars;

    //this list will have to be updated with new models until php comes out with a way to:
    // use PhpCupcakes\Models\All;
   // use PhpCupcakes\Models\MyCategory;
   // use PhpCupcakes\Models\MyObject;


?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Portal: Search Results</title>
        <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css"> <!--linkhere-->
        <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css"> <!--linkhere-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
    </head>
    <body>
        <div class="container">
            <header>
                <?php 
                $h1 = 'Search Results';
                echo LoadHtml::loadInclude('header', ['h1' => $h1]);
                ?>
    <?php
    $searchFeatureVariables = [
        'admin' => '1',
        'posturl' => ConfigVars::getSiteUrl().'/admin_portal/search.php'     /*linkhere*/
    ];
    ?>
    <div class="search bg-info"><?= LoadHtml::loadInclude('searchform', $searchFeatureVariables); ?></div>
</header>
    <nav class="bg-success-light text-dark"><?= LoadHtml::loadInclude('adminnav'); ?>
    </nav>
    <div class="mainparent">
    <main> <?php
$searchTerm = isset($_GET['searchTerm']) && $_GET['searchTerm'] != '';
$searchTable = isset($_GET['searchTable']) && $_GET['searchTable'] != '';
$searchColumn = isset($_GET['searchColumn']) && $_GET['searchColumn'] != '';

if ($searchTerm && $searchTable && $searchColumn) {

    // Get the current page and items per page from the URL parameters
    list($currentPage, $itemsPerPage) = PaginationHelper::getPaginationParams();
    

    $searchQuery = $_GET['searchTerm'];
    $dataColumn = $_GET['searchColumn'];
    // Search all columns for "cupcake"

    $classNamespace = 'PhpCupcakes\\Models\\' . $_GET['searchTable'];
    $tableName = $classNamespace::getTableName();


    ?><h5>Searching for <?= $dataColumn ?>s in <?= $_GET['searchTable'] ?> that matches '<?= $searchQuery ?>'</h5><?php
    

    $tableViewer = new CupcakeDAL();
    $tableViewer->displayTableSearch($classNamespace, $tableName, $currentPage, $itemsPerPage, $dataColumn, $searchQuery);

    // Display the pagination links
    $totalObjects = $classNamespace::getTotalofSearch($searchQuery, $dataColumn);
    PaginationHelper::displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage, $searchQuery);
} else {
    echo "Please try your search again.";
}
    ?>

</main>
</div>
</div>
</body>
</html>