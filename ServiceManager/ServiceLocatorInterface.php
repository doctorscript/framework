<?php
namespace DoctorScript\ServiceManager;

interface ServiceLocatorInterface
{
    
    /**
     * Get service by name
     *
     * @param  string $serviceName service name
     * @param  bool $useCache
     * @return mixed
    */
    public function get($serviceName, $useCache);
    
    /**
     * Check if service exists
     * 
     * @param  string $serviceName
     * @return bool true if service exists or false otherwise    
    */
    public function has($serviceName);
}
?>