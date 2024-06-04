<?php
namespace PhpCupcakes\Helpers; 

use PhpCupcakes\Config\ConfigVars;

class LoadHtml
{

    public static function loadComponent($componentName, $variables = [])
    {
        // Construct the path to the component file
        $componentPath = ConfigVars::getDocRoot(). '/Views/components/' . $componentName . '.phtml';       /*linkhere*/
    

        // Check if the component file exists
        if (file_exists($componentPath)) {
            // Get the component content
            extract($variables);
            ob_start();
            include $componentPath;
            $return = ob_get_clean();
    
    
            // Return the rendered component
            return $return;
        } else {
            // If the component file doesn't exist, return an error message
            return "Error: Component '$componentName' not found.";
        }
    }
    public static function loadInclude($includeName, $variables = [])
    {
        // Construct the path to the component file
        $includePath =  ConfigVars::getDocRoot(). '/Views/includes/' . $includeName . '.phtml';       /*linkhere*/

        // Check if the component file exists
        if (file_exists($includePath)) {
            // Get the component content
            extract($variables);
            ob_start();
            include $includePath;
            $return = ob_get_clean();
    
    
            // Return the rendered component
            return $return;
        } else {
            // If the component file doesn't exist, return an error message
            return "Error: Include file '$includePath' not found.";
        }
    }
}