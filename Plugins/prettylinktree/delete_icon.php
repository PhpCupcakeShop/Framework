<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Framework/autoload.php';

use prettylinktree\Models\LinkTree;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = $_POST['order'];

    // Update the sort order in the database
    foreach ($order as $index => $id) {
        $link = LinkTree::find($id);
        $link->delete($id);
        echo $link->id;
    }


    // Redirect back to the main page
    header('Location: index.phtml');
    exit;
}
?>