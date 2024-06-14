<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Framework/autoload.php';

use prettylinktree\Models\LinkTree;



    if (isset($_POST['custom_icon']) && $_POST['custom_icon'] != '') {
        $icon = $_POST['custom_icon'] . ' ' . $_POST['class'];
        //$icon_class = $_POST['class'];
    } elseif (isset($_POST['social_media'])) {
        $icon = $_POST['social_media'];
    } else {
    }

    try {
    $treeLink = new LinkTree;
    $treeLink->icon = $icon;
    //$treeLink->icon_class = $icon_class;
    $treeLink->icon_color = $_POST['color'];
    $treeLink->font_size = $_POST['fontSize'];
    $treeLink->url = $_POST['url'];
    $treeLink->sortOrder = 1;
    $treeLink->save();
    $lastInsertId = $treeLink->id;


    echo $lastInsertId;
    // Redirect back to the main page
    header('Location: index.phtml');
    exit;

    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>