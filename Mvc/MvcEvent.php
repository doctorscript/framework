<?php
namespace DoctorScript\Mvc;

use DoctorScript\EventManager\Event;
use DoctorScript\Http\Request\RequestInterface;
use DoctorScript\Http\Response\ResponseInterface;
use DoctorScript\Router\RouteMatchInterface;
use DoctorScript\Mvc\View\ViewInterface;
use DoctorScript\Mvc\ApplicationInterface;

class MvcEvent extends Event
{
    const EVENT_ROUTE                    = 'MvcRoute';
    const EVENT_FAILED_REQUEST         = 'FailedRequest';
    const EVENT_BEFORE_ACTION          = 'BeforeAction';
    const EVENT_PARSE_ACTION_RESULT = 'ParseActionResult';
    const EVENT_COMPLETE_REQUEST    = 'CompleteRequest';
    
    /**
     * @var RequestInterface
    */
    protected $request;
    
    /**
     * @var ResponseInterface
    */
    protected $response;
    
    /**
     * @var RouteMatchInterface
    */
    protected $routeMatch;
    
    /**
     * @var ViewInterface
    */
    protected $view;
    
    /**
     * Set request instance
     *
     * @param RequestInterface $request
     * @return void
    */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }
    
    /**
     * Get request instance
     *
     * @return RequestInterface
    */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Set route match instance
     *
     * @param  RouteMatchInterface $routeMatch
     * @return void
    */
    public function setRouteMatch(RouteMatchInterface $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }
    
    /**
     * Get route match instance
     *
     * @return RouteMatchInterface
    */
    public function getRouteMatch()
    {
        return $this->routeMatch;
    }
    
    /**
     * Set response instance
     *
     * @param ResponseInterface $response
     * @return void
    */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
    
    /**
     * Get response instance
     *
     * @return ResponseInterface
    */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Set root view instance
     *
     * @param ViewInterface $view
     * @return void
    */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }
    
    /**
     * Get root view instance
     *
     * @return ViewInterface
    */
    public function getView()
    {
        return $this->view;
    }
    
    /**
     * Set application instance
     *
     * @param  ApplicationInterface $application
     * @return void
    */
    public function setApplication(ApplicationInterface $application)
    {
        $this->application = $application;
    }
    
    /**
     * Get application instance
     *
     * @return ApplicationInterface
    */
    public function getApplication()
    {
        return $this->application;
    }
}