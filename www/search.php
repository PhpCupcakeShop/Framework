<?php

require_once "../Framework/autoload.php"; /*linkhere*/

use PhpCupcakes\Helpers\PaginationHelper;
use PhpCupcakes\Helpers\UrlHelper;
use PhpCupcakes\Helpers\LoadHtml;
use PhpCupcakes\DAL\VanillaCupcakeDAL;
use PhpCupcakes\Config\ConfigVars;
?>

    <!DOCTYPE html>
    <html lang="en">
     <head>
  <meta charset="UTF-8">
  <meta name="description" content="PHP Cupcake Shop Framework Demo">
 <meta name="keywords" content="PHP, Framework, Demo">
  <meta name="author" content="aemegi">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Results</title>
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/styles.css">   <!--linkhere--> 
    <link rel="stylesheet" href="<?= ConfigVars::getWWW() ?>/assets/css/colors.css">  <!--linkhere-->  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
    </head>
    <body>
        <div class="container">
            <header>
                <?php
                $h1 = "Search Results";
                echo LoadHtml::loadInclude("header", ["h1" => $h1]);
                ?>
            <div class="search bg-info"><?= LoadHtml::loadInclude(
                "searchform"
            ) ?></div>
</header>
    <nav class="bg-success-light text-dark"><?= LoadHtml::loadInclude("nav") ?>
    <?php
    use PhpCupcakes\EditMode\EditLink;
    echo EditLink::displayEditModeNav();
    echo EditLink::displayEditLink();
    ?></nav>
    <div class="mainparent">
    <main> <?php
    $searchTerm = isset($_GET["searchTerm"]) && $_GET["searchTerm"] !== "";
    $searchTable = isset($_GET["searchTable"]) && $_GET["searchTable"] !== "";
    $searchColumn =
        isset($_GET["searchColumn"]) && $_GET["searchColumn"] !== "";

    if ($_GET["searchTable"] == "all") {

        // Get the current page and items per page from the URL parameters
        list(
            $currentPage,
            $itemsPerPage,
        ) = PaginationHelper::getPaginationParams();

        $searchQuery = $_GET["searchTerm"];

        $result = VanillaCupcakeDAL::searchAllTables(
            $searchQuery,
            $currentPage,
            $itemsPerPage
        );
        $allResults = $result["results"];
        $totalObjects = $result["totalObjects"];
        ?><h5>Search for '<?= $searchQuery ?>' across all tables</h5><?php
// Display the combined search results

foreach ($allResults as $result) { ?>
        <div style="display: flex; flex-direction: row; row-wrap: wrap; padding: 20px;">
        <?php foreach ($result as $key => $value) { ?>
        
            <div class="quickpadding"><?= $key ?>: <?= $value ?></div>
            <?php if ($key == "id") {
                echo LoadHtml::loadComponent("/editmode/displayEdit", [
                    "id" => $value,
                    "type" => $_GET["searchTable"],
                ]);
            }} ?>
        </div>
   
        <?php }

// Display the pagination links
PaginationHelper::displayPaginationLinks(
    $totalObjects,
    $currentPage,
    $itemsPerPage
);

    } elseif ($searchTerm && $searchTable && $searchColumn) {

        // Get the current page and items per page from the URL parameters
        list(
            $currentPage,
            $itemsPerPage,
        ) = PaginationHelper::getPaginationParams();

        $searchQuery = $_GET["searchTerm"];
        $dataColumn = $_GET["searchColumn"];
        $classNamespace = "PhpCupcakes\\Models\\" . $_GET["searchTable"];
        $tableName = $classNamespace::getTableName();

        $searchResult = $classNamespace::searchOneTable(
            $searchQuery,
            $dataColumn,
            $currentPage,
            $itemsPerPage
        );
        $objects = $searchResult["results"];
        ?><h5>Search for <?= $dataColumn ?>s in <?= $_GET[
    "searchTable"
] ?> that matches '<?= $searchQuery ?>'</h5><?php
// Display the objects
if (!empty($objects)) {
    foreach ($objects as $object) { ?>
        <div style="display: flex; flex-direction: row; padding: 20px;">
        <?php foreach ($object as $key => $value) { ?>
            <div class="quickpadding"><?= $key ?>: <?= is_array($value)
    ? implode(", ", $value)
    : $value ?></div>
            <?php if ($key == "id") {
                echo LoadHtml::loadComponent("/editmode/displayEdit", [
                    "id" => $value,
                    "type" => $_GET["searchTable"],
                ]);
            }} ?>
        </div>
        <?php }
} else {
    echo "No results found.";
}
// Display the pagination links
$totalObjects = $searchResult["totalObjects"];
PaginationHelper::displayPaginationLinks(
    $totalObjects,
    $currentPage,
    $itemsPerPage
);

    } else {
        echo "Please try your search again.";
    }
    ?>

</main>
</div>
</div>
</body>
</html>