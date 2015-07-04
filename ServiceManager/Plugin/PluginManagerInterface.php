<?php
namespace DoctorScript\ServiceManager\Plugin;

use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\ServiceManager\ServiceLocatorAwareInterface;

interface PluginManagerInterface extends ServiceLocatorInterface, ServiceLocatorAwareInterface
{
    /**
     * Validate plugin by given name
     * Ensure is plugin implements particular marker interface
     *
     * @param string $plugin
     * @return void
    */
    public function validatePlugin($plugin);
}