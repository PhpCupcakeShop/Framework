<?php
namespace PhpCupcakes\Helpers;

class UrlParamsHelper
{
    // Get the URL path
    public $path;
    
    // Split the path into segments
    public $segments = [];

    public function __construct()
    {
        $this->path = $_SERVER['REQUEST_URI'];
        $this->segments = $this->getPathSegments();
    }

    /**
     * Get the path segments, excluding the GET parameters
     * @return array
     */
    protected function getPathSegments()
    {
        $parts = explode('?', $this->path);
        $pathPart = $parts[0];
        return explode('/', trim($pathPart, '/'));
    }

    public function get($index)
    {
        return isset($this->segments[$index]) ? $this->segments[$index] : null;
    }
}