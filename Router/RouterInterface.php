<?php
namespace DoctorScript\Router;

interface RouterInterface
{
    /**
     * Set routes
     *
     * @param  array $routes
     * @return void
    */
    public function setRoutes(array $routes);
    
    /**
     * Check if current request uri matched any registered route pattern
     *
     * @param  string $uri
     * @return bool true if has matched or false otherwise
    */
    public function hasMatch($uri);
}