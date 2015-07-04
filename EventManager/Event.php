<?php
namespace DoctorScript\EventManager;

class Event implements EventInterface
{
    /**
     * @var string
    */
    protected $name;
    
    /**
     * @var mixed
    */
    protected $target;
    
    /**
     * @var array
    */
    protected $params = [];
    
    /**
     * @var bool
    */
    protected $stopPropagation = false;
    
    /**
     * Set event name
     *
     * @param string $name
     * @return void
    */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get event name
     *
     * @return string
    */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set target where event triggered
     *
     * @param mixed $target
     * @return void
    */
    public function setTarget($target)
    {
        $this->target = $target;
    }
    
    /**
     * Get target where event triggered
     *
     * @return mixed
    */
    public function getTarget()
    {
        return $this->target;
    }
    
    /**
     * Set event object params
     *
     * @param array $params
     * @return void
    */
    public function setParams(array $params)
    {
        $this->params = $params;
    }
    
    /**
     * Get event object params
     *
     * @return array
    */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Set event object param
     *
     * @param string $name
     * @param mixed  $value
     * @return void
    */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    /**
     * Get event object param
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
    */
    public function getParam($name, $default = null)
    {
        return array_key_exists($name,  $this->params) ? $this->params[$name] : $default;
    }
    
    /**
     * Set event propagation flag
     *
     * @param bool $flag
     * @return void
    */
    public function stopPropagation($flag = true)
    {
        $this->stopPropagation = $flag;
    }
    
    /**
     * Get event propagation flag
     *
     * @return bool
    */
    public function propagationIsStopped()
    {
        return $this->stopPropagation;
    }
}