<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
// Generate a CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include("bootstrap.php");

class AutoloadFunctions {
    public static function getFoldersForAutoloader($directory)
    {
        $folders = array();

        // Check if the directory exists
        if (is_dir($directory)) {
            // Open the directory
            $dir = opendir($directory);

            // Loop through the contents of the directory
            while (($file = readdir($dir)) !== false) {
                // Check if the current item is a directory
                if (is_dir($directory . '/' . $file) && $file !== '.' && $file !== '..') {
                    // Add the folder name to the array
                    $folders[] = $file;
                }
            }

            // Close the directory
            closedir($dir);
        }

        // Return the array of folder names
        return $folders;
    }
}

spl_autoload_register(function ($Name) {
    $destroyName = str_replace('PhpCupcakes', '', $Name);
    $destroyName = str_replace('Phpcupcakes', '', $destroyName);
    $destroyName = str_replace('MyApp', '', $destroyName);
    $classFile = $_SERVER['DOCUMENT_ROOT'] . '/Framework/'. str_replace('\\', '/', $destroyName) . '.php';       /*linkhere*/


    $modules = AutoloadFunctions::getFoldersForAutoloader($_SERVER['DOCUMENT_ROOT'].'/Modules');

    foreach ($modules as $moduleName) {
        $attempt = str_replace('\\', '/', $Name);   
    $moduleFile = $_SERVER['DOCUMENT_ROOT'] . '/Modules/'. $attempt . '.php';    /*linkhere*/
    if (file_exists($moduleFile)) {
        include $moduleFile;
    }
    }

    $appmodels = AutoloadFunctions::getFoldersForAutoloader($_SERVER['DOCUMENT_ROOT'].'/Models');

    foreach ($appmodels as $model) {
        $attempt = str_replace('\\', '/', $Name);   
    $modelFile = $_SERVER['DOCUMENT_ROOT'] . '/Models/'. $attempt . '.php';    /*linkhere*/
    if (file_exists($modelFile)) {
        include $modelFile;
    }
    }

    $plugins = AutoloadFunctions::getFoldersForAutoloader($_SERVER['DOCUMENT_ROOT'].'/Plugins');
    foreach ($plugins as $pluginName) {
    $attempt = str_replace('\\', '/', $Name);
    $pluginFile = $_SERVER['DOCUMENT_ROOT'] . '/Plugins/'. $attempt . '.php';       /*linkhere*/
    if (file_exists($pluginFile)) {
        include $pluginFile;
    }
    }

    $modelFile = $_SERVER['DOCUMENT_ROOT'] . '/'. str_replace('\\', '/', $destroyName) . '.php';              /*linkhere*/
    $configFile = $_SERVER['DOCUMENT_ROOT'] . '/'. str_replace('\\', '/', $destroyName) . '.php';       /*linkhere*/
    //$classFile = str_replace('//', '/', $classFile);
    if (file_exists($classFile)) {
        include $classFile;
    } elseif (file_exists($modelFile)) {
        include $modelFile;
    } elseif (file_exists($configFile)) {
        include $configFile;
    } elseif (isset($moduleFile)) {
    } elseif (isset($pluginFile)) {
    } else {
        echo 'Class file not found: ' . $classFile;
    }
});

include ($_SERVER['DOCUMENT_ROOT'] . "/Config/mybootstrap.php");