<?php
namespace DoctorScript\Router;

class Regex implements RouterInterface
{
    /**
     * Registered routes
     *
     * @var array
    */
    private $routes = [];
    
    /**
     * Route matched parameters
     *
     * @var array
    */
    private $params = [];
    
    /**
     * @var string
    */
    private $matchedRouteName = '';
    
    private $routeMatch;
    
    /**
     * Constructor
     *
     * @param array $routes
    */
    public function __construct(array $routes = [])
    {
        if (count($routes) != 0) {
            $this->setRoutes($routes);
        }
    }
    
    /**
     * Set routes
     *
     * @param  array $routes
     * @return void
    */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }
    
    /**
     * Check if current request uri matched any registered route pattern
     *
     * @param string $uri
     * @return bool true if has matched or false otherwise
    */
    public function hasMatch($uri)
    {
        foreach ($this->routes as $name => $definition) {
            if (preg_match('#^' . $definition['pattern'] . '$#', $uri, $params)) {
                $match = $this->getRouteMatch();
                $match->setParams($this->normalizeParameters($params));
                $match->addParam('route', $name);
                $match->addParam('controller', $definition['controller']);
                $match->addParam('action', $definition['action']);
                return true;
            }
        }

        return false;
    }
    
    /**
     * Remove all integer keys from matched parameters
     *
     * @param array $parameters
     * @return array
    */
    private function normalizeParameters(array $parameters)
    {
        $result = [];
        
        foreach ($parameters as $name => $parameter) {
            if (!is_int($name)) {
                $result[$name] = $parameter;
            }
        }

        return $result;
    }

    /**
     * @return array route matched parameters
    */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * @return string matched route name 
    */
    public function getMatchedRouteName()
    {
        return $this->matchedRouteName;
    }
    
    public function setRouteMatch(RouteMatchInterface $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }
    
    public function getRouteMatch()
    {
        return $this->routeMatch;
    }
}