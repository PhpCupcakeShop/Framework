<?php
// start or continue session
use PhpCupcakes\Config\ConfigVars;

if (!isset($_SESSION['user_name'])) {
    $redirect = urlencode($_SERVER['PHP_SELF']);
    echo '<p>unauthorized access!</p>';
    echo '<p><form method="post" action="https://'.ConfigVars::getWWW().'/editmode/on">   '.    /*linkhere*/
       ' <input type="hidden" name="returnurl" value="'. $redirect .'">
        <input class="false-link" type="submit" name="editmode" value="click here">
    </form> to go to edit mode.</p>';
    echo '<p>If you do not want to be in edit mode, ' .
        '<a href="'.ConfigVars::getWWW().        /*linkhere*/
        '">click here</a>.</p>';
    die();
}
?>