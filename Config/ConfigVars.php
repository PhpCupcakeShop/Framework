<?php

namespace PhpCupcakes\Config;

class ConfigVars {

    private static $workingdirectory = '';

    public static function getSiteUrl()
    {
    $workingdirectory = '';
    $pathforall = 'https://' .$_SERVER['SERVER_NAME'] . $workingdirectory;    /*linkhere*/

        return $pathforall;
    }
    public static function getDocRoot()
    {
    $workingdirectory = '';
    $pathforall = $_SERVER['DOCUMENT_ROOT'] . $workingdirectory;    /*linkhere*/

        return $pathforall;
    }
    public static function getFrameworkSrc()  //change this to change all easily
    {
    
            return self::getDocRoot().'/Framework';    /*linkhere*/
   
    }
    public static function getWWW()  //change this to change all easily
    {
            return self::getSiteUrl().'/www';    /*linkhere*/
  

    }
    public static function getModelDir()  //change this to change all easily
    {
            return self::getDocRoot().'/Models';    /*linkhere*/
 

    }
    public static function myAppName()  //change this to change all easily
    {
            return 'MyApp';
      

    }
    public static function searchModelParam()  //change this to change all easily
    {
            return 4;
      

    }
} 