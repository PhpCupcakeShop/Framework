<?php
namespace PhpCupcakes\Helpers;

    use PhpCupcakes\Config\ConfigVars;
    use PhpCupcakes\Helpers\FileFunctions;

    class GetModels {
       private static function getModelsNamespace($namespaceDir)
    {
        
        $folderPath = $namespaceDir;
        $segments = explode('/', trim($folderPath, '/'));
        $s = ConfigVars::searchModelParam();
        
        $debug = $s;
        $s = $s + 3;
        $namespace = $segments[$s];
        $debug = ' namespace: ' . $namespace;
        $baseNamespace = basename($namespaceDir);
    
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $filePath = $folderPath . "/" . $file;
                if (is_file($filePath) && substr($file, -4) === ".php") {
                    $className = substr($file, 0, -4);
                    $fullClassName = $namespace. '\\' .$baseNamespace . '\\' . $className;
                }
            }
        }
        return $fullClassName;
    }
    public static function returnAllModelNamespaces() {

    $myapps = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Models');
        foreach ($myapps as $myapp) {
            if (file_exists(ConfigVars::getDocRoot().'/Models/'.$myapp.'/Models')) {
        $models[] = self::getModelsNamespace(ConfigVars::getDocRoot().'/Models/'.$myapp.'/Models');
            }
        }

    $modules = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Modules');
    foreach ($modules as $module) {
        if (file_exists(ConfigVars::getDocRoot().'/Modules/'.$module.'/Models')) {
    $moremodels[] = self::getModelsNamespace(ConfigVars::getDocRoot().'/Modules/'.$module.'/Models');
        }
    }
    $plugins = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Plugins');
    foreach ($plugins as $plugin) {
        if (file_exists(ConfigVars::getDocRoot().'/Plugins/'.$plugin.'/Models')) {
    $evenmoremodels[] = self::getModelsNamespace(ConfigVars::getDocRoot().'/Plugins/'.$plugin.'/Models');
        }
    }
    if (isset($moremodels)) {
    $models = array_merge($models, $moremodels);
    } 
    if (isset($evenmoremodels)) {
    $models = array_merge($models, $evenmoremodels);
    }

    return $models;
}
    }