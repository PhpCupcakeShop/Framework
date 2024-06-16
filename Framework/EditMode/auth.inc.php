<?php
use PhpCupcakes\Config\ConfigVars;
// start or continue session


if (!isset($_SESSION['edit'])) {
    $redirect = urlencode($_SERVER['PHP_SELF']);
    echo '<p>unauthorized access!</p>';
    echo '<p><form method="post" action="'.ConfigVars::getSiteUrl().'/editmode/on">   '.    /*linkhere*/
       ' <input type="hidden" name="returnurl" value="'. $redirect .'">
        <input class="false-link" type="submit" name="editmode" value="click here">
    </form> to go to edit mode.</p>';
    echo '<p>If you do not want to be in edit mode, ' .
        '<a href="'.ConfigVars::getSiteUrl() .        /*linkhere*/
        '">click here</a>.</p>';
    die();
}
?>