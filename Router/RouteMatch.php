<?php
namespace DoctorScript\Router;

class RouteMatch implements RouteMatchInterface
{
    private $params = [];
    
    public function __construct(array $params = [])
    {
        if (count($params) == 0) {
            $this->setParams($params);
        }
    }
    
    /**
     * Set matched route params
     *
     * @param  array $params
     * @return void
    */
    public function setParams(array $params)
    {
        $this->params = $params;
    }
    
    /**
     * Get matched route params
     *
     * @return array
    */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Add param to matched route params
     *
     * @param  string $name
     * @param  mixed $value
     * @param  bool $allowOverride
     * @return void
     * @throws \BadMethodCallException if try override without set special flag to true
    */
    public function addParam($name, $value, $allowOverride = false)
    {
        if ($this->hasParam($name) && $allowOverride === false) {
            throw new \BadMethodCallException(sprintf(
                'Cannot override %s ', $name
            ));
        }

        $this->params[$name] = $value;
    }
    
    /**
     * Get param by name
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
    */
    public function getParam($name, $default = null)
    {
        if (!$this->hasParam($name)) {
            return $default;
        }

        return $this->params[$name];
    }
    
    /**
     * Check if has param
     *
     * @param  string $name
     * @return bool true if has param or false otherwise
    */
    public function hasParam($name)
    {
        return array_key_exists($name, $this->params);
    }
}