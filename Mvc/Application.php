<?php
namespace DoctorScript\Mvc;

use DoctorScript\ServiceManager\ServiceManager;
use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\EventManager\EventManagerInterface;
use DoctorScript\EventManager\EventInterface;
use DoctorScript\ModuleManager\ModuleManagerInterface;
use DoctorScript\Router\RouterInterface;

class Application implements ApplicationInterface
{
    /**
     * @var ServiceLocatorInterface
    */
    protected $serviceManager;
    
    /**
     * @var EventManagerInterface
    */
    protected $eventManager;
    
    /**
     * @var ModuleManagerInterface
    */
    protected $moduleManager;
    
    /**
     * @var RouterInterface
    */
    protected $router;
    
    /**
     * Initialize application before run
     *
     * @param array $config
     * @return ApplicationInterface
    */
    public static function init(array $config)
    {
        $serviceConfig  = isset($config['service_manager']) ? $config['service_manager'] : [];
        $serviceManager = new ServiceManager($serviceConfig);
        $serviceManager->addService('ApplicationConfig', $config);

        return $serviceManager->get('DoctorScript\Mvc\ApplicationInterface');
    }
    
    /**
     * Run application after initialization
     *
     * @return void
    */
    public function run()
    {
        $moduleManager = $this->getModuleManager();
        $moduleManager->loadModules();

        $config = $moduleManager->getLoadedModulesConfig();
        $serviceManager = $this->getServiceManager();
        $serviceManager->addService('config', $config);

        $eventManager = $this->getEventManager();
        $moduleManager->initializeLoadedModules($eventManager->getEvent());

        $router = $this->getRouter();
        $router->setRoutes(isset($config['routes']) ? $config['routes'] : []);

        $request = $eventManager->getEvent()->getRequest();

        if (!$router->hasMatch($request->getUri())) {
            $eventManager->trigger(MvcEvent::EVENT_FAILED_REQUEST);
        } else {            
            $eventManager->getEvent()->setRouteMatch($router->getRouteMatch());
            $eventManager->trigger(MvcEvent::EVENT_ROUTE, $this);
        }

        $this->completeRequest($eventManager->getEvent());
    }

    /**
     * Complete incoming request
     * After all application specified operations is done this method is called
     * It triggers MvcEvent::EVENT_COMPLETE_REQUEST event and send response to client
     *
     * @param MvcEvent $e
     * @return void
    */
    public function completeRequest(EventInterface $e)
    {
        $this->getEventManager()->trigger($e::EVENT_COMPLETE_REQUEST);

        $response = $e->getResponse();
        $response->setContent($e->getParam('responseContent'));
        $response->sendHeaders();
        $response->send();
    }
    
    /**
     * Set applicaion events manager
     *
     * @param EventManagerInterface
     * @return void
    */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
    
    /**
     * Get applicaion events manager
     *
     * @return EventManagerInterface
    */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    /**
     * Set application services manager
     *
     * @param ServiceLocatorInterface
     * @return void
    */
    public function setServiceManager(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }
    
    /**
     * Get application services manager
     *
     * @return ServiceLocatorInterface
    */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
    
    /**
     * Set application modules manager
     *
     * @param ModuleManagerInterface
     * @return void
    */    
    public function setModuleManager(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Get application modules manager
     *
     * @return ModuleManagerInterface
    */
    public function getModuleManager()
    {
        return $this->moduleManager;
    }

    /**
     * Set router
     *
     * @param RouterInterface
     * @return void
    */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Get router
     *
     * @return RouterInterface
    */
    public function getRouter()
    {
        return $this->router;
    }
}