<?php
namespace DoctorScript\ServiceManager\Plugin;

use DoctorScript\ServiceManager\ServiceLocatorInterface;

interface PluginManagerAwareInterface
{
    /**
     * Set plugin manager
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
    */
    public function setPluginManager(ServiceLocatorInterface $serviceLocator);
    
    /**
     * Get plugin manager
     *
     * @return ServiceLocatorInterface
    */
    public function getPluginManager();
}