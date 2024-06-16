<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/Framework/autoload.php"; /*linkhere*/
use PhpCupcakes\Helpers\UrlParamsHelper;

$urlParams = new UrlParamsHelper;

$param1nth = $urlParams->get(0);
$param2nth = $urlParams->get(1);
$param3nth = $urlParams->get(2);
$param4nth = $urlParams->get(3);

use PhpCupcakes\Config\ConfigVars;
$dir = ConfigVars::getDocRoot().'/';

// admin/GeoBsnsMod
            $objectName = $param2nth;
            $modelName = $param4nth;
            $routedClassNamespaceRoot = $objectName;
            $routedClassNamespace = $param2nth.'\Models\\'.$param4nth;



if (!$param1nth) {
        require $dir . 'www/welcome.phtml';
}

if (isset($param1nth) && !$param2nth) {
    switch ($param1nth) {
        case 'admin':
            require $dir . 'Framework/CRUDs/index.phtml';
        break;
        case 'devpage':
            require 'allclasses.php';
        break;
}
} elseif (isset($param2nth) && $param1nth == 'admin' && !isset($param3nth)) {
    switch ($param2nth) {
        case 'search': 
            require $dir . 'Framework/CRUDs/search.php';
        break;
        default: 
            $WWW = $dir.'Framework/CRUDs/index.phtml';
            if (file_exists($WWW)) { require $WWW; }
        break;
        }
    }
    if (isset($param4nth)) {
    switch ($param3nth) {
        case 'add':
            $addWWW = $dir.'Framework/CRUDs/addObject.phtml';
            if (file_exists($addWWW)) { 
            require $addWWW; }
        break;
        case 'added':
            $addedWWW = $dir.'Framework/CRUDs/ObjectAdded.phtml';     
            if (file_exists($addedWWW)) { require $addedWWW; }
        break;
        case 'viewall':
            $viewAllWWW = $dir.'Framework/CRUDs/ObjectAll.php';          
            if (file_exists($viewAllWWW)) { 
            require $viewAllWWW; }
        break;
        case 'view':
            $viewWWW = $dir.'Framework/CRUDs/Object.phtml';        
            if (file_exists($viewWWW)) { require $viewWWW; }
        break;
        case 'edit':
            $editWWW = $dir.'Framework/CRUDs/editObject.phtml';        
            if (file_exists($editWWW)) { require $editWWW; }
        break;
        case 'update':
            $updateWWW = $dir.'Framework/CRUDs/ObjectUpdated.phtml';          
            if (file_exists($updateWWW)) { require $updateWWW; }
        break;
        case 'delete':
            $deleteWWW = $dir.'Framework/CRUDs/deleteObject.phtml';        
            if (file_exists($deleteWWW)) { require $deleteWWW; }
        break;
    }
} elseif (isset($param2nth) && $param1nth == 'editmode') {
    switch ($param2nth) {
        case 'on':
            include $dir.'Framework/EditMode/session_edit.php';
        break;
        case 'off':
            include $dir.'Framework/EditMode/session_edit.php';
        break;
        default: 
            include $dir.'www/welcome.phtml';
        break;
    }
    # code...
}