<?php
    /*linkhere*/
namespace PhpCupcakes\Helpers;

use PhpCupcakes\Config\ConfigVars;

class UrlHelper
   {
    public static function generateUrl($route, $params = [])
    {
        $baseUrl = ConfigVars::getSiteUrl();
        $url = $baseUrl . '/' . $route;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
    public static function routedUrl($route, $myObject, $id = 1)
    {
        $routes = [
            'welcome' =>  ConfigVars::getSiteUrl().'welcome.phtml',
            'editmode_on' => ConfigVars::getSiteUrl().'editmode/on',
            'editmode_off' => ConfigVars::getSiteUrl().'editmode/off',
            'view' => ConfigVars::getSiteUrl().'/'.$myObject . '/view/' .$id,
            'edit' => ConfigVars::getSiteUrl().'/'.$myObject . '/edit/'. $id,
            'update' => ConfigVars::getSiteUrl().'/'.$myObject . '/update/'.$id,
            'add' => ConfigVars::getSiteUrl().'/'.$myObject . '/add',
            'added' => ConfigVars::getSiteUrl().'/'.$myObject . '/added',
            'delete' => ConfigVars::getSiteUrl().'/'.$myObject . '/delete/'.$id,
        ];
    
        $route = $routes[$route];
    
        return $route;
    }
    
    public static function pluralUrl($route, $myObject, $page, $itemsperpage, $sortfeature = 'id')
    {
        $routes = [
            'my_objects' => $myObject,
            'my_objects_sort' => $myObject . '/sortby'.$sortfeature.'/page'.$page.'/'.$itemsperpage.'perpage',
            'my_objects_page' => $myObject . '/page'.$page.'/'.$itemsperpage.'perpage',
        ];
    
        $route = $routes[$route];
    
        return $route;
    }

   }