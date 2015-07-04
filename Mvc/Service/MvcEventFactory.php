<?php
namespace DoctorScript\Mvc\Service;

use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\ServiceManager\ServiceFactoryInterface;
use DoctorScript\EventManager\EventInterface;
use DoctorScript\Mvc\MvcEvent;

class MvcEventFactory implements ServiceFactoryInterface
{
    /**
     * Create MvcEvent and inject appropriate dependencies
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return EventInterface
    */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {    
        $mvcEvent = new MvcEvent();
        
        $mvcEvent->setView($serviceLocator->get('DoctorScript\Mvc\View\ViewInterface'));
        $mvcEvent->setRequest($serviceLocator->get('DoctorScript\Http\Request\RequestInterface'));
        $mvcEvent->setResponse($serviceLocator->get('DoctorScript\Http\Response\ResponseInterface'));

        return $mvcEvent;
    }
}