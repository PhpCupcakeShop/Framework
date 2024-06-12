<?php

use PhpCupcakes\Helpers\FileFunctions;
use PhpCupcakes\Config\ConfigVars;

$wwwModels = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Models');

$plugins = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Plugins');

$modules = FileFunctions::getFolders(ConfigVars::getDocRoot().'/Modules');


foreach ($plugins as $key => $plugin) {
    $modelfiles = FileFunctions::getModelsNamespace(ConfigVars::getDocRoot().'/Plugins/'.$plugin.'/Models');

    foreach ($modelfiles as $modelfile) {
        //take out the extra model out of $modelfile
        $classNamespace = $plugin.'\\'.$modelfile;
        
        $modelName = explode('\\', $modelfile);
        $modelfile = $modelName[1];

    ?> 
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$plugin.'/viewall/'.$modelfile; ?>">View All <?= $classNamespace::getUserFriendlyName() ?></a> |
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$plugin.'/add/'.$modelfile; ?>">Add a <?= $classNamespace::getUserFriendlyName() ?></a>

    <?php
    }
}

foreach ($modules as $module) {
    $modelfiles = FileFunctions::getModelsNamespace(ConfigVars::getDocRoot().'/Plugins/'.$module.'/Models');
    if (!$modelfiles) {} else {
    foreach ($modelfiles as $modelfile) {
        $classNamespace = $module.'\\'.$modelfile;
    ?> 
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$module.'/viewall/'.$modelfile; ?>">View All <?= $classNamespace::getUserFriendlyName() ?></a> |
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$module.'/add/'.$modelfile; ?>">Add a <?= $classNamespace::getUserFriendlyName() ?></a>

    <?php
    }
    }
}



foreach ($wwwModels as $wwwModel) {
    $modelfiles = FileFunctions::getModelsNamespace(ConfigVars::getDocRoot().'/Models/'.$wwwModel.'/Models');
    foreach ($modelfiles as $modelfile) {
    $classNamespace2 = $wwwModel.'\\'.$modelfile;
    ?> 
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$wwwModel.'/viewall/'.$modelfile; ?>">View All <?= $classNamespace2::getUserFriendlyName() ?></a> |
    <a href="<?= ConfigVars::getSiteUrl().'/admin/'.$wwwModel.'/add/'.$modelfile; ?>">Add a <?= $classNamespace2::getUserFriendlyName() ?></a>
    <?php
    }
}