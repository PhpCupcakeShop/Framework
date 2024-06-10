<?php

 namespace PhpCupcakes\Config;
 class ErrorReporting {
  public static function logError($msg) {
        $msg = nl2br("\n \n". date("l, Y-m-d") ."\n". $msg);
        error_log($msg, 3, "errors.txt");
        error_log($msg, 1, "aemegi@icloud.com");
    }

 }

 /*

error_reporting(E_ALL);
ini_set("display_errors", 1); */
