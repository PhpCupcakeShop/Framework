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
        $this->segments = explode('/', trim($this->path, '/'));
    }

    public function get($index)
    {
        return isset($this->segments[$index]) ? $this->segments[$index] : null;
    }
}

/**** This can be used in the following way: 
 * $urlHelper = new UrlParamsHelper();
 * $firstParam = $urlHelper->get(0);
 * $secondParam = $urlHelper->get(1); */

