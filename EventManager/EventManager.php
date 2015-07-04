<?php
namespace DoctorScript\EventManager;

use DoctorScript\EventManager\EventInterface;

class EventManager implements EventManagerInterface
{
    /**
     * @var array
    */
    protected $listeners   = [];
    
    /**
     * @var identifiers
    */
    protected $identifiers = [];
    
    /**
     * @var EventInterface $event
    */
    protected $event;
    
    /**
     * Constructor
     *
     * @param array $identifiers
    */
    public function __construct(array $identifiers = [])
    {
        if (count($identifiers) > 0) {
            $this->setIdentifiers($identifiers);
        }
    }
    
    /**
     * Set event manager identifiers
     *
     * @param array $identifiers
     * @return void
    */
    public function setIdentifiers(array $identifiers)
    {
        $this->identifiers = $identifiers;
    }
    
    /**
     * Clear all identifiers
     *
     * @return void
    */
    public function clearIdentifiers()
    {
        $this->identifiers = [];
    }
    
    /**
     * Get listeners for event manager
     *
     * @return array
    */
    public function getListeners()
    {
        return $this->listeners;
    }
    
    /**
     * Attach listener for event with priority(optional)
     *
     * @param  string $name
     * @param  mixed $callback
     * @param  int $priority
     * @return void
     * @throws \BadMethodCallException if $callback is not valid callback or existed class
    */
    public function attach($name, $callback, $priority = 1)
    {
        if (!is_callable($callback) && !class_exists($callback)) {
            throw new \BadMethodCallException(sprintf(
                'Listener must be string class name or valid callback, %s given', 
                is_object($callback) ? get_class($callback) : gettype($callback)
            ));
        }

        $this->listeners[$name][] = compact('callback', 'priority');
    }
    
    /**
     * Detach listener by name
     *
     * @param  string $name
     * @return bool true if listener successfully detached or false otherwise
    */
    public function detach($name)
    {
        if (isset($this->listeners[$name])) {
            unset($this->listeners[$name]);
            return true;
        }

        return false;
    }
    
    /**
     * Triggers events related with given event name
     *
     * @param  string $name
     * @param  mixed $target
     * @param  array $params
     * @return void
    */
    public function trigger($name, $target = null, array $params = [])
    {
        if (count($this->identifiers) > 0) {
            $sharedManager = $this->getSharedManager();
            foreach ($this->identifiers as $identifier) {
                if ($sharedManager->hasIdentifier($identifier)) {
                    $listeners = $sharedManager->getListenersUsingIdentifier($identifier, $name);
                    foreach ($listeners as $listener) {
                        $this->attach($name, $listener['callback'], $listener['priority']);
                    }
                }
            }
        }

        if (!isset($this->listeners[$name])) {
            return false;
        }

        uasort($this->listeners[$name], function($a, $b){
            return ($a['priority'] < $b['priority']) ? -1 : 1;
        });
        
        $event = $this->getEvent();
        $event->setName($name);
        $event->setTarget($target);
        $event->setParams($params);
        
        foreach ($this->listeners[$name] as $listener) {
            $callback = is_callable($listener['callback']) ? $listener['callback'] : new $listener['callback'];
            $callback($event);
            
            if ($event->propagationIsStopped()) {
                break;
            }
        }
    }
    
    /**
     * Get event object
     * If event object is not set, returns standard event object
     *
     * @return EventInterface
    */
    public function getEvent()
    {
        if (is_null($this->event)) {
            $this->setEvent(new Event);
        }
        return $this->event;
    }
    
    /**
     * Set event object
     *
     * @param  EventInterface $event
     * @return void
    */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }
    
    /**
     * Set shared manager
     *
     * @param  SharedManagerInterface $sharedManager
     * @return void
    */
    public function setSharedManager(SharedManagerInterface $sharedManager)
    {
        $this->sharedManager = $sharedManager;
    }
    
    /**
     * Get SharedEventManager
     *
     * @return SharedEventManagerInterface
    */
    public function getSharedManager()
    {
        return $this->sharedManager;
    }
}