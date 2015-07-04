<?php
namespace DoctorScript\EventManager;

class SharedEventManager implements SharedEventManagerInterface
{    
    /**
     * @var array
    */
    private $identifiedEvents = [];

    /**
     * Attach shared listener for event with priority(optional)
     *
     * @param  string $identifier
     * @param  string $name
     * @param  mixed $callback
     * @param  int $priority
     * @return void
    */
    public function attach($identifier, $event, $callback, $priority = 1)
    {
        $this->identifiedEvents[$identifier][$event][] = compact('callback', 'priority');
    }
    
    /**
     * Detach shared listener by identifier
     *
     * @param  string $identifier
     * @return bool true if identifier is detached or false otherwise
    */
    public function detach($identifier)
    {
        if ($this->hasIdentifier($identifier)) {
            unset($this->identifiedEvents[$identifier]);
            return true;
        }

        return false;
    }
    
    /**
     * Check if Shared event manager has given identifier
     *
     * @param  string $identifier
     * @return bool true if any event is attached for given identifier or false otherwise
    */
    public function hasIdentifier($identifier)
    {
        return array_key_exists($identifier, $this->identifiedEvents);
    }

    /**
     * Get listeners by given identifier for particular event
     *
     * @param  string $identifier
     * @param  string $name
     * @return array
    */
    public function getListenersUsingIdentifier($identifier, $name)
    {
        if ($this->hasIdentifier($identifier)) {
            return $this->identifiedEvents[$identifier][$name];
        }

        return [];
    }
}