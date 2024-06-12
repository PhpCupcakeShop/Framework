<?php
namespace PhpCupcakes\Helpers;
class FileFunctions {
/**
     * Retrieves a list of model class names from a specified namespace directory.
     *
     * @param string $namespaceDir The directory containing the model classes.
     * @return \Generator An iterator that yields the class names.
     */
    public static function getModels($namespaceDir)
    {
        $folderPath = $namespaceDir;
        if (file_exists($folderPath)){
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $filePath = $folderPath . "/" . $file;
                if (is_file($filePath) && substr($file, -4) === ".php") {
                    $className = substr($file, 0, -4);
                    yield $className;
                }
            }
        }
        }
    }

    public static function getModelsNamespace($namespaceDir)
{
    
    $folderPath = $namespaceDir;
    $segments = explode('/', trim($folderPath, '/'));
    $baseNamespace = basename($namespaceDir);
    if (file_exists($folderPath)){
    $files = scandir($folderPath);
    foreach ($files as $file) {
        if ($file !== "." && $file !== "..") {
            $filePath = $folderPath . "/" . $file;
            if (is_file($filePath) && substr($file, -4) === ".php") {
                $className = substr($file, 0, -4);
                $fullClassName[] = $baseNamespace . '\\' . $className;
            }
        }
    }
    return $fullClassName;
    }
}

/**
 * Retrieves a list of model class names from specified namespace directories.
 *
 * @param array $namespaceDirMap An associative array where the keys are the namespace prefixes
 *                              and the values are the directories containing the model classes.
 * @return \Generator An iterator that yields the class names.
 */
public static function getManyModels(array $namespaceDirMap)
{
    foreach ($namespaceDirMap as $namespacePrefix => $namespaceDir) {
        $folderPath = $namespaceDir;

        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $filePath = $folderPath . "/" . $file;
                if (is_file($filePath) && substr($file, -4) === ".php") {
                    $className = substr($file, 0, -4);
                    $fullClassName = $namespacePrefix . '\\' . $className;
                    yield $fullClassName;
                }
            }
        }
    }
}
        /**
     * Get an array of folders in a given directory
     *
     * @param string $directory The path to the directory you want to list the folders from
     * @return array An array of folder names
     */
    public static function getFolders($directory)
    {
        $folders = array();

        // Check if the directory exists
        if (is_dir($directory)) {
            // Open the directory
            $dir = opendir($directory);

            // Loop through the contents of the directory
            while (($file = readdir($dir)) !== false) {
                // Check if the current item is a directory
                if (is_dir($directory . '/' . $file) && $file !== '.' && $file !== '..') {
                    // Add the folder name to the array
                    $folders[] = $file;
                }
            }

            // Close the directory
            closedir($dir);
        }

        // Return the array of folder names
        return $folders;
    }

    


}