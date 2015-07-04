<?php
namespace DoctorScript\ModuleManager;

use DoctorScript\Autoloader\SplAutoloaderInterface;
use DoctorScript\EventManager\EventInterface;

class ModuleManager implements ModuleManagerInterface
{
    /**
     * @var array
    */
    private $loadedModules = [];
    
    /**
     * @var array
    */
    private $config = [];
    
    /**
     * Constructor
     *
     * @param array $config
    */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Load application modules
     *
     * @return void
    */
    public function loadModules()
    {
        $modulesPaths       = isset($this->config['module_paths']) ? $this->config['module_paths'] : [];
        $availableModules = isset($this->config['available_modules']) ? $this->config['available_modules'] : [];

        $loader = $this->getAutoloader();
        $loader->setPaths($modulesPaths);
        $loader->register();

        foreach ($availableModules as $availableModule) {
            $moduleClassName = '\\' . $availableModule . '\\' . 'Module';            
            $this->loadedModules[$availableModule] = new $moduleClassName;
        }
    }
    
    /**
     * Initialize each module if init() method is exists in module class
     *
     * @param  EventInterface $e
     * @return void
    */
    public function initializeLoadedModules(EventInterface $e)
    {
        foreach ($this->getLoadedModules() as $module) {
            if (method_exists($module, 'init')) {
                $module->init($e);
            }
        }
    }
    
    /**
     * Set modules autoloader
     *
     * @param  SplAutoloaderInterface
     * @return void
    */
    public function setAutoloader(SplAutoloaderInterface $autoloader)
    {
        $this->autoloader = $autoloader;
    }
    
    /**
     * Get modules autoloader
     *
     * @return SplAutoloaderInterface
    */
    public function getAutoloader()
    {
        return $this->autoloader;
    }
    
    /**
     * Get loaded modules configuration
     *
     * @return array
    */
    public function getLoadedModulesConfig()
    {    
        $config = [];
            
        foreach ($this->getLoadedModules() as $module) {
            if (method_exists($module, 'getConfig')) {
                $config = array_merge($config, $module->getConfig());
            }
        }

        return $config;        
    }
    
    /**
     * Get module class list of loaded modules
     *
     * @return array
    */
    public function getLoadedModules()
    {
        return $this->loadedModules;
    }
}