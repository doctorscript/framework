<?php
namespace DoctorScript\EventManager;

interface SharedEventManagerInterface
{
    /**
     * Attach shared listener for event with priority(optional)
     *
     * @param  string $identifier
     * @param  string $name
     * @param  mixed $callback
     * @param  int $priority
     * @return void
    */
    public function attach($identifier, $name, $callback, $priority);
    
    /**
     * Detach shared listener by identifier
     *
     * @param  string $identifier
     * @return bool true if identifier is detached or false otherwise
    */
    public function detach($identifier);
}