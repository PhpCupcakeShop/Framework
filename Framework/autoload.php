<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);

$debug = "echo me for error info";
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
    $className = str_replace('PhpCupcakes', '', $Name);
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/';
        $classPath = str_replace('\\', '/', $className) . '.php';
    
        // Check the Framework directory first
        $frameworkPath = $baseDir . 'Framework' . $classPath;
        if (file_exists($frameworkPath)) {
            include_once $frameworkPath;
            return;
        }    

        // Check the Config directory next
        $configPath = $baseDir . $classPath;
        if (file_exists($configPath)) {
            include_once $configPath;
            return;
        }
    
        // Check the Modules directory next
        $modulesPath = $baseDir . 'Modules/' . $classPath;
        if (file_exists($modulesPath)) {
            include_once $modulesPath;
            return;
        }
    
        // Check the Models directory
        $modelsPath = $baseDir . 'Models/' . $classPath;
        if (file_exists($modelsPath)) {
            include_once $modelsPath;
            return;
        }
    
        // Check the Plugins directory
        $pluginsPath = $baseDir . 'Plugins/' . $classPath;
        if (file_exists($pluginsPath)) {
            include_once $pluginsPath;
            return;
        }
    
        // If the class is not found in any of the directories, display an error
        //echo 'Class file not found: ' . $className . ' @ ' . $modelsPath;
    });

include ($_SERVER['DOCUMENT_ROOT'] . "/Config/mybootstrap.php");