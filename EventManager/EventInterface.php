<?php
namespace DoctorScript\EventManager;

interface EventInterface
{
    /**
     * Set event name
     *
     * @param string $name
     * @return void
    */
    public function setName($name);
    
    /**
     * Get event name
     *
     * @return string
    */
    public function getName();
    
    /**
     * Set target where event triggered
     *
     * @param mixed $target
     * @return void
    */
    public function setTarget($target);   
    
    /**
     * Get target where event triggered
     *
     * @return mixed
    */
    public function getTarget();
    
    /**
     * Set event object params
     *
     * @param  array $params
     * @return void
    */
    public function setParams(array $params);
    
    /**
     * Get event object params
     *
     * @return array
    */
    public function getParams();
    
    /**
     * Set event object param
     *
     * @param string $name
     * @param mixed  $value
     * @return void
    */
    public function setParam($name, $value);
    
    /**
     * Get event object param
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
    */
    public function getParam($name, $default = null);
    
    /**
     * Set event propagation flag
     *
     * @param bool $flag
     * @return void
    */
    public function stopPropagation($flag = true);
    
    /**
     * Get event propagation flag
     *
     * @return bool
    */
    public function propagationIsStopped();
}