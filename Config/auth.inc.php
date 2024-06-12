<?php
// start or continue session
use PhpCupcakes\Config\ConfigVars;

if (!isset($_SESSION['edit'])) {
    echo '<p>unauthorized access!</p>';
    
        
    $url = parse_url($_SERVER['REQUEST_URI']);
    $query = array();
    parse_str($url['query'] ?? '', $query);
    $redirect = urlencode($url['path'] . (count($query) > 0 ? '?' . http_build_query($query) : ''));
    ?>
    
    <form method="post" action="<?= ConfigVars::getSiteUrl() ?>/editmode/on">     <!--linkhere-->
        <input type="hidden" name="returnurl" value="<?= $redirect ?>">
        <input type="hidden" name="startsession" value="on">
        [<input class="false-link" type="submit" name="editmode" value="click here">]
    </form>
     <?php echo 'to go to edit mode.</p>';
    echo '<p>If you do not want to be in edit mode, ' .
        '<a href="'.ConfigVars::getWWW().        /*linkhere*/
        '">click here</a>.</p>';
    die();
}
?>