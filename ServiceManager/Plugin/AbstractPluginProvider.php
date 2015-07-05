<?php
namespace DoctorScript\ServiceManager\Plugin;

use DoctorScript\ServiceManager\ServiceLocatorInterface;

abstract class AbstractPluginProvider implements PluginManagerAwareInterface
{
    /**
     * Service locator implementation instance
     *
     * @var ServiceLocatorInterface
    */
    protected $pluginManager;

    /**
     * If any class extends AbstractPluginProvider and by instance trying call to undefined method, called method name uses as plugin name 
     * After detecting called method name, AbstractPluginProvider query to PluginManager and search instance for plugin by given name
     * If instance is found, that may be called with two ways 
     * First, if instance is callable, it`s called as callback with passed arguments
     * Second, if instance is not callable, returns just plugin object    
     *
     * @param  string $pluginName
     * @param  array  $args
     * @return mixed
     * @throws \DoctorScript\ServiceManager\Exception\ServiceNotFoundException if plugin instance not registered as service
     * @throws Exception\InvalidPluginManagerException if plugin manager not implements ServiceLocatorInterface
    */
    public function __call($pluginName, array $args = [])
    {
        $manager = $this->getPluginManager();

        if (!$manager instanceOf ServiceLocatorInterface) {
            throw new Exception\InvalidPluginManagerException(sprintf(
                'Plugin manager must be instance of ServiceLocatorInterface, %s given', 
                is_object($manager) ? get_class($manager) : gettype($manager)
            ));
        }
        
        $plugin = $manager->get($pluginName);
        $manager->validatePlugin($plugin);

        if (is_callable($plugin)) {
            return call_user_func_array($plugin, $args);
        }
        
        return $plugin;
    }

    /**
     * Set plugin manager
     *
     * @param ServiceLocatorInterface $pluginManager
     * @return void
    */
    public function setPluginManager(ServiceLocatorInterface $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    /**
     * Get plugin manager
     *
     * @return ServiceLocatorInterface
    */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
}
