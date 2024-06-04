<?php
session_start();
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
        include $modelFile;
    } else {
        echo 'Class file not found: ' . $classFile;
    }
});

include ($_SERVER['DOCUMENT_ROOT'] . "/Config/mybootstrap.php");