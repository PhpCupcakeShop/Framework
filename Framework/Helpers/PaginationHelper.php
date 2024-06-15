<?php
namespace PhpCupcakes\Helpers;         /*linkhere*/ /*also a file that needs reduction in complexity*/

class PaginationHelper
{
    public static function getPaginationParams()
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 10;
        return array($currentPage, $itemsPerPage);
    }

    public static function displayPaginationLinks($totalObjects, $currentPage, $itemsPerPage, $searchQuery = null)
    {
        $totalPages = ceil($totalObjects / $itemsPerPage);
    
        echo "<nav>";
        echo "<ul class='pagination'>";
    
        // Display the "Previous" link
        if ($currentPage > 1) {
            ?>
            <li class='page-item'>
                <a class='page-link' href='?page=<?= ($currentPage - 1) ?>&items_per_page=<?= $itemsPerPage ?>'>
                    Previous
                </a>
            </li>
            <?php
        }
    
        // Display the page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $currentPage) ? 'disabled' : '';
            $url = self::generatePaginationUrl($_GET, ['page'=> $i,'items_per_page'=> $itemsPerPage]);
            $link = ($i == $currentPage) ? "<span class='page-link'>$i</span>" : "<a class='page-link' href='$url'>$i</a>";
            echo "<li class='page-item $active'>$link</li>";
        }
    
        // Display the "Next" link
        if ($currentPage < $totalPages) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($currentPage + 1) . "&items_per_page=$itemsPerPage'>Next</a></li>";
        }
    
        echo "</ul>";
        echo "</nav>";
    }
    
    public static function generatePaginationUrl($params = [], $pageparams = [])
    {
        $queryParams = [];
        if (isset($_GET['page']) && isset($_GET['items_per_page'])) {
            $queryParams = array_diff_key($_GET, ['page' => 0, 'items_per_page' => 0]);
        }
        $queryParams = array_merge($queryParams, $params, $pageparams);
        $url = '?' . http_build_query($queryParams);
        return $url;
    }

}