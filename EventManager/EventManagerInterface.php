<?php
namespace DoctorScript\EventManager;

interface EventManagerInterface
{
    /**
     * Set event manager identifiers
     *
     * @param array $identifiers
     * @return void
    */
    public function setIdentifiers(array $identifiers);
    
    /**
     * Clear all identifiers
     *
     * @return void
    */
    public function clearIdentifiers();
    
    /**
     * Get listeners for event manager
     *
     * @return array
    */
    public function getListeners();
    
    /**
     * Attach listener for event with priority
     *
     * @param  string $name
     * @param  mixed $callback
     * @param  int $priority
     * @return void
    */
    public function attach($name, $callback, $priority);
    
    /**
     * Detach listener by name
     *
     * @param  string $name
     * @return bool true if listener successfully detached or false otherwise
    */
    public function detach($identifier);
    
    /**
     * Triggers events related with given event name
     *
     * @param  string $name
     * @param  mixed $target
     * @param  array $params
     * @return void
    */
    public function trigger($name, $target, array $params);
    
    /**
     * Get event object
     * If event object is not set, returns standard event object
     *
     * @return EventInterface
    */
    public function getEvent();

    /**
     * Set event object
     *
     * @param  EventInterface $event
     * @return void
    */
    public function setEvent(EventInterface $event);
}