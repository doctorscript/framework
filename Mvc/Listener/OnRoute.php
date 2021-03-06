<?php
namespace DoctorScript\Mvc\Listener;

use DoctorScript\EventManager\EventInterface;

class OnRoute
{
    /**
     * Triggers if request matched by router
     *
     * It`s simple invoke controller and call appropriate action
     * Retrieved data returned by action passes to MvcEvent::EVENT_PARSE_ACTION_RESULT listener for compose response data
     *
     * @param  EventInterface $e
     * @return void
     * @throws \RuntimeException if controller or action of controller not exists
    */
    public function __invoke(EventInterface $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        $actionName     = $routeMatch->getParam('action').'Action';

        $controllerManager = $e->getTarget()
                               ->getServiceManager()
                               ->get('DoctorScript\Mvc\Controller\ControllerManager');

        if (!$controllerManager->has($controllerName)) {
            throw new \RuntimeException(sprintf(
                'Controller %s not exists', $controllerName
            ));
        }
       
        $controller = $controllerManager->get($controllerName);
        if (!method_exists($controller, $actionName)) {
            throw new \RuntimeException(sprintf(
                'Action %s of controller %s is not exists', $actionName, $controllerName
            ));
        }
        
        $controllerManager->injectControllerDependencies($controller);
        $controllerNS = substr($controllerName, 0, strrpos($controllerName, '\\'));

        $eventManager = $e->getTarget()->getEventManager();
        $eventManager->trigger($controllerNS);
        $eventManager->trigger($controllerName);
        $eventManager->trigger($e::EVENT_BEFORE_ACTION);
        $eventManager->trigger($e::EVENT_PARSE_ACTION_RESULT, null, [
            'actionResult' => $controller->$actionName()
        ]);
    }
}
