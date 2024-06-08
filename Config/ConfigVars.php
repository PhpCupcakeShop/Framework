<?php

namespace PhpCupcakes\Config;

class ConfigVars {

    private static $workingdirectory = '/demo';

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
    public static function getFrameworkSrc($rootfolder = 1)  //change this to change all easily
    {
        if ($rootfolder == 0) {
            return self::getDocRoot();
        } else {
            return self::getDocRoot().'/Framework';    /*linkhere*/
        }

    }
    public static function getWWW($rootfolder = 1)  //change this to change all easily
    {
        if ($rootfolder == 0) {
            return self::getSiteUrl();
        } else {
            return self::getSiteUrl().'/www';    /*linkhere*/
        }

    }
    public static function getModelDir($rootfolder = 1)  //change this to change all easily
    {
        if ($rootfolder == 0) {
            return self::getDocRoot();
        } else {
            return self::getDocRoot().'/Models/';    /*linkhere*/
        }

    }
} 