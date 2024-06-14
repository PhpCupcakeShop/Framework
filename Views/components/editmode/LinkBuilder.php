<?php

use PhpCupcakes\Helpers\FileFunctions;
use PhpCupcakes\Config\ConfigVars;

$directories = [
    'Plugins' => FileFunctions::getFolders(ConfigVars::getDocRoot() . '/Plugins'),
    'Modules' => FileFunctions::getFolders(ConfigVars::getDocRoot() . '/Modules'),
    'Models' => FileFunctions::getFolders(ConfigVars::getDocRoot() . '/Models'),
];

foreach ($directories as $dirName => $dirItems) {
    if (is_array($dirItems) && !empty($dirItems)) {
        foreach ($dirItems as $item) {
            $modelsPath = ConfigVars::getDocRoot() . "/{$dirName}/{$item}/Models";
            $modelFiles = FileFunctions::getModelsNamespace($modelsPath);

            if (is_array($modelFiles) && !empty($modelFiles)) {
                foreach ($modelFiles as $modelFile) {
                    $namespaceParts = explode('\\', $modelFile);
                    $modelClassName = end($namespaceParts);
                    $modelNamespace = implode('\\', array_slice($namespaceParts, 0, -1));

                    try {
                        $modelClass = new ReflectionClass($modelNamespace . '\\' . $modelClassName);
                        $userFriendlyName = $modelClass->getStaticPropertyValue('userFriendlyName');
                    } catch (Exception $e) {
                        $userFriendlyName = $modelClassName;
                    }

                    $viewAllUrl = ConfigVars::getSiteUrl() . "/admin/{$item}/viewall/{$modelClassName}";
                    $addUrl = ConfigVars::getSiteUrl() . "/admin/{$item}/add/{$modelClassName}";

                    echo "<a href=\"{$viewAllUrl}\">View All {$userFriendlyName}</a> | ";
                    echo "<a href=\"{$addUrl}\">Add a {$userFriendlyName}</a><br>";
                }
            }
        }
    }
}