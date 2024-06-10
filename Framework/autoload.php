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

spl_autoload_register(function ($Name) {
    $destroyName = str_replace('PhpCupcakes', '', $Name);
    $destroyName = str_replace('Phpcupcakes', '', $destroyName);
    $classFile = $_SERVER['DOCUMENT_ROOT'] . '/Framework/'. str_replace('\\', '/', $destroyName) . '.php';       /*linkhere*/
    $modelFile = $_SERVER['DOCUMENT_ROOT'] . '/'. str_replace('\\', '/', $destroyName) . '.php';              /*linkhere*/
    $configFile = $_SERVER['DOCUMENT_ROOT'] . '/'. str_replace('\\', '/', $destroyName) . '.php';       /*linkhere*/
    //$classFile = str_replace('//', '/', $classFile);
    if (file_exists($classFile)) {
        include $classFile;
    } elseif (file_exists($modelFile)) {
        include $modelFile;
    } elseif (file_exists($configFile)) {
        include $configFile;
    } else {
        echo 'Class file not found: ' . $classFile;
    }
});

include ($_SERVER['DOCUMENT_ROOT'] . "/Config/mybootstrap.php");